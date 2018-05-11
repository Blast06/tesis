<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('pages.notification', compact('notifications'));
    }

    public function count()
    {
        return response()->json(['count' => auth()->user()->unreadNotifications->count()], Response::HTTP_OK);
    }

    public function markAsRead()
    {
        auth()->user()->notifications->markAsRead();
        return back();
    }

    public function readNotification(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return back();
    }
}
