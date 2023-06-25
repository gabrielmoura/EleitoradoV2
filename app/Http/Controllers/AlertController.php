<?php

namespace App\Http\Controllers;

class AlertController extends Controller
{
    public function notifications()
    {
        $alerts = auth()->user()->unreadNotifications()->paginate(10);

        return view('dash.alerts.notifications', compact('alerts'));
    }

    public function notificationShow($id)
    {
        $alert = auth()->user()->unreadNotifications()->findOrFail($id);
        $alert->markAsRead();

        return redirect()->route('dash.alerts.notifications');
    }

    public function alertDestroy($id)
    {
        $alert = auth()->user()->notifications()->findOrFail($id);
        $alert->delete();

        return response()->json(['success' => true]);
    }

    public function alertRead($id)
    {
        $alert = auth()->user()->notifications()->findOrFail($id);
        $alert->markAsRead();

        return response()->json(['success' => true]);
    }
}
