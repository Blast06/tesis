<?php

namespace App\Http\Controllers\Client;

use DB;
use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\{Conversation, Notifications\NewClientMessage, User, Website};

class MessageController extends Controller
{
    /**
     * MessageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param \App\Website|null $website
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Website $website = null)
    {
        return view('pages.message', compact('website'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createMessage()
    {
        $websites = Website::select('id', 'name', 'username')->get()->map(function ($website) {
            return [
                'label' => $website->name . " (@{$website->username})",
                'value' => $website->id
            ];
        });

        return view('pages.new_message', compact('websites'));
    }

    /**
     * @return mixed
     * @throws \Throwable
     */
    public function storeUser()
    {
        $newMessage = DB::transaction(function () {
            $conversation = auth()->user()->conversation()->firstOrCreate([
                'website_id' => request()->website_id,
            ]);

            return $conversation->messages()->create([
                'user_send' => auth()->id(),
                'message' => request()->message,
            ]);
        });

        broadcast(new NewMessage($newMessage->conversation, $newMessage))->toOthers();
        Notification::send([$newMessage->conversation->website->user], new NewClientMessage($newMessage->conversation, $newMessage));

        return $this->successResponse(['data' => $newMessage], 201);
    }

    /**
     * @param \App\Website $website
     * @return mixed
     * @throws \Throwable
     */
    public function storeWebsite(Website $website)
    {
        $user = User::findOrFail(request()->user_id);
        $newMessage = DB::transaction(function () use ($website, $user){
            $conversation = $website->conversation()
                ->where('user_id', $user->id)
                ->firstOrFail();

            return $conversation->messages()->create([
                'user_send' => auth()->id(),
                'message' => request()->message,
            ]);
        });

        broadcast(new NewMessage($newMessage->conversation, $newMessage))->toOthers();
        Notification::send([$user], new NewClientMessage($newMessage->conversation, $newMessage));

        return $this->successResponse(['data' => $newMessage], 201);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function conversationUser()
    {
        $conversations = auth()->user()->conversation()
            ->select('id', 'website_id', 'user_id')
            ->orderBy('created_at', 'DESC')
            ->with([
                'messages' => function ($messages) {
                    $messages->orderBy('created_at', 'DESC');
                },
                'website'
            ])
            ->get();

        return $this->successResponse(['data' => $conversations]);
    }

    /**
     * @param \App\Website $website
     * @return \Illuminate\Http\JsonResponse
     */
    public function conversationWebsite(Website $website)
    {
        $conversations = $website->conversation()
            ->select('id', 'website_id', 'user_id')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->load(['messages' => function ($q) {
                $q->orderBy('created_at', 'DESC');
            }, 'user' => function ($q) {
                $q->select('id', 'name');
            }]);

        return $this->successResponse(['data' => $conversations]);
    }

    /**
     * @param \App\Conversation $conversation
     * @return \Illuminate\Http\JsonResponse
     */
    public function showConversation(Conversation $conversation)
    {
        return $this->successResponse(['data' => $conversation->messages]);
    }

}
