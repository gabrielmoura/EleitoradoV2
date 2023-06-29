<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Activitylog\Models\Activity;

class EventController extends Controller
{
    public function index(): View
    {
        return view('dash.event.index');
    }

    public function show(Event $event): View
    {
        $event->with('persons', 'address');

        return view('dash.event.show', compact('event'));
    }

    public function history($pid): View|RedirectResponse
    {
        try {
            $tag = Event::findPid($pid)
                ->firstOrFail();
            $histories = Activity::where('subject_type', Event::class)
                ->where('subject_id', $tag->id)
                ->get();

            return view('dash.event.history', compact('histories'));
        } catch (\Throwable $throwable) {
            report($throwable);

            return redirect()->back();
        }
    }
}
