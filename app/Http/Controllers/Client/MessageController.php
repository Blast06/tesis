<?php

namespace App\Http\Controllers\Client;

use DB;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.message');
    }

    /**
     * @return mixed
     * @throws \Throwable
     */
    public function messageToWebsite()
    {
        return DB::transaction(function () {
            $conversation = auth()->user()->conversation()->firstOrCreate([
                'website_id' => request()->website_id,
            ]);

            $conversation->messages()->create([
                'user_send' => auth()->id(),
                'message' => request()->message,
            ]);
        });

    }

    public function conversation()
    {
        $conversations = auth()->user()->conversation()
            ->select('id', 'website_id')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->load(['messages' => function ($q) {
                $q->orderBy('created_at', 'DESC');
                }, 'website' => function ($q) {
                $q->select('id', 'name');
            }]);

        return $this->responseOne($conversations, 200);
    }
}
