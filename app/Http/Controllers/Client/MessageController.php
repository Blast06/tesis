<?php

namespace App\Http\Controllers\Client;

use DB;
use App\Events\NewMessage;
use App\{Conversation, Website};
use App\Http\Controllers\Controller;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Website $website = null)
    {
        return view('pages.message', compact('website'));
    }

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

        return $this->responseOne($newMessage, 201);
    }

    /**
     * @param \App\Website $website
     * @return mixed
     * @throws \Throwable
     */
    public function storeWebsite(Website $website)
    {
        $newMessage = DB::transaction(function () use ($website){
            $conversation = $website->conversation()->firstOrCreate([
                'user_id' => request()->user_id,
            ]);

            return $conversation->messages()->create([
                'user_send' => auth()->id(),
                'message' => request()->message,
            ]);
        });

        broadcast(new NewMessage($newMessage->conversation, $newMessage))->toOthers();

        return $this->responseOne($newMessage, 201);
    }

    public function conversationUser()
    {
        $conversations = auth()->user()->conversation()
            ->select('id', 'website_id', 'user_id')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->load(['messages' => function ($q) {
                $q->orderBy('created_at', 'DESC');
                }, 'website' => function ($q) {
                $q->select('id', 'name');
            }]);

        return $this->responseOne($conversations, 200);
    }

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

        return $this->responseOne($conversations, 200);
    }

    public function showConversation(Conversation $conversation)
    {
        return $this->responseOne($conversation->messages, 200);
    }

}
