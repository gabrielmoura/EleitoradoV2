<?php

namespace App\Http\Controllers;

class AlertController extends Controller
{
    public function notifications()
    {
        $alerts = auth()->user()->company->unreadNotifications()->paginate(10);
        $markRead = true;

        return view('dash.alerts.notifications', compact('alerts', 'markRead'));
    }

    public function notificationAll()
    {
        $alerts = auth()->user()->company->notifications()->paginate(10);
        $markRead = false;

        return view('dash.alerts.notifications', compact('alerts', 'markRead'));
    }

    public function notificationShow($id)
    {
        $alert = auth()->user()->company->unreadNotifications()->findOrFail($id);
        if ($alert) {
            $alert->markAsRead();
        }

        return redirect()->route('user.alert');
    }

    public function alertDestroy($id)
    {
        $alert = auth()->user()->company->notifications()->findOrFail($id);
        $alert->delete();

        return response()->json(['success' => true]);
    }

    public function alertRead($id)
    {
        $alert = auth()->user()->company->notifications()->findOrFail($id);
        $alert->markAsRead();

        return response()->json(['success' => true]);
    }
}
