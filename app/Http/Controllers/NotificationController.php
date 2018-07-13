<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * NotificationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('pages.notification', compact('notifications'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function count()
    {
        return response()->json(['count' => auth()->user()->unreadNotifications->count()], Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead()
    {
        auth()->user()->notifications->markAsRead();
        return back();
    }

    /**
     * @param \Illuminate\Notifications\DatabaseNotification $notification
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function readNotification(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        if (isset($notification->data['url'])) {
            return redirect($notification->data['url']);
        }

        return back();
    }
}
