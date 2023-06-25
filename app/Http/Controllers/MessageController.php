<?php

namespace App\Http\Controllers;

class MessageController extends Controller
{
    public function messageDestroy($id)
    {
        $message = auth()->user()->messages()->findOrFail($id);
        $message->delete();

        return response()->json(['success' => true]);
    }

    public function messageRead($id)
    {
        $message = auth()->user()->messages()->findOrFail($id);
        $message->markAsRead();

        return response()->json(['success' => true]);
    }

    public function notifications()
    {
        $messages = auth()->user()->unreadNotifications()->paginate(10);

        return view('dash.messages.notifications', compact('messages'));
    }

    public function notificationShow($id)
    {
        $message = auth()->user()->unreadNotifications()->findOrFail($id);
        $message->markAsRead();

        return redirect()->route('dash.messages.notifications');
    }
}
