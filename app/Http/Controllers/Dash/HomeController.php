<?php

namespace App\Http\Controllers\Dash;

use App\Charts\PersonChart;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Person;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $person = Person::all()->pluck('created_at')->groupBy(fn ($date) => $date->translatedFormat('M'))->map(fn ($item) => $item->count());
        $group = Group::all()->pluck('created_at')->groupBy(fn ($date) => $date->translatedFormat('M'))->map(fn ($item) => $item->count());

        $personChart = new PersonChart;

        $personChart->dataset('Pessoas', 'line', $person->values())
            ->options([
                'fill' => true,
                'borderColor' => '#51C1C0',
                'backgroundColor' => '#51C1C0',
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 2,
            ]);

        $personChart->dataset('Grupos', 'line', $group->values())
            ->options([
                'fill' => true,
                'borderColor' => '#FECB2E',
                'backgroundColor' => '#FECB2E',
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 2,
            ]);

        $personChart->labels($group->keys());

        return view('dash.dashboard', compact('personChart'));
    }
}
