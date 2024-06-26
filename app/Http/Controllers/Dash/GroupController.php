<?php

namespace App\Http\Controllers\Dash;

use App\Exports\Contact;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class GroupController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        return view('dash.group.index');
    }

    public function show(Group $group)
    {
        $persons = $group->persons()->paginate(100);

        return view('dash.group.show', compact('group', 'persons'));
    }

    public function history($pid)
    {
        try {
            $tag = Group::withTrashed()->findPid($pid)
                ->firstOrFail();
            $histories = Activity::where('subject_type', Group::class)
                ->where('subject_id', $tag->id)
                ->get();

            return view('dash.group.history', compact('histories'));
        } catch (\Throwable $throwable) {
            report($throwable);

            return redirect()->back();
        }
    }

    public function getContacts(Request $request)
    {
        $group = Group::findPid($request->group)->firstOrFail();

        $persons = $group->persons()->get();

        return Excel::download(new Contact($persons), 'contatos.csv');
    }
}
