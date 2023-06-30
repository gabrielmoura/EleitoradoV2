<?php

namespace App\Http\Controllers\Dash;

use App\Charts\Dash\DemandsCompletedChart;
use App\Charts\PersonChart;
use App\Http\Controllers\Controller;
use App\Models\Demand;
use App\Models\Group;
use App\Models\Person;
use App\Service\Enum\PersonOptions;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $personAll = Person::with('address')->orderBy('created_at')->get();
        $person = $personAll
            ->pluck('created_at')
            ->groupBy(fn ($date) => $date->translatedFormat('M'))
            ->map(fn ($item) => $item->count());
        $group = Group::orderBy('created_at')
            ->pluck('created_at')
            ->groupBy(fn ($date) => $date->translatedFormat('M'))
            ->map(fn ($item) => $item->count());
        $demand = Demand::with('type')
            ->orderBy('created_at')->get();

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

        $personChart->labels($person->keys());
        $personChart->title('Pessoas e Grupos');

        $demandChart = new DemandsCompletedChart;
        $demandChart->dataset(
            'Demandas',
            'line',
            $demand->pluck('created_at')
                ->groupBy(fn ($date) => $date->translatedFormat('M'))
                ->map(fn ($item) => $item->count())->values()
        )
            ->options([
                'fill' => true,
                'borderColor' => '#51C1C0',
                'backgroundColor' => '#51C1C0',
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 2,
            ]);
        $demandChart->labels(
            $demand->pluck('created_at')
                ->groupBy(fn ($date) => $date->translatedFormat('M'))
                ->map(fn ($item) => $item->count())
                ->keys()
        );
        $demandChart->title('Demandas');

        $demandChartType = new DemandsCompletedChart;
        $demandChartType->dataset(
            name: 'Demandas',
            type: 'line',
            data: $demand->pluck('type')
                ->groupBy(fn ($date) => $date->name)
                ->map(fn ($item) => $item->count())
                ->values()
        )->options([
            'fill' => true,
            'borderColor' => '#51C1C0',
            'backgroundColor' => '#51C1C0',
            'borderWidth' => 2,
            'pointRadius' => 2,
            'pointHoverRadius' => 2,
        ]);
        $demandChartType->labels($demand->pluck('type')->groupBy(fn ($date) => $date->name)->map(fn ($item) => $item->count())->keys());
        $demandChartType->title('Demandas por Tipo');

        // Contagem de pessoas por sexo
        $personSex = $personAll->countBy(fn (Person $person) => PersonOptions::getSexOption($person->sex));
        $personSexChart = new PersonChart;
        $personSexChart->dataset('Pessoas', 'pie', $personSex->values())
            ->options([
                'fill' => true,
                'borderColor' => '#51C1C0',
                'backgroundColor' => '#51C1C0',
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 2,
            ]);
        $personSexChart->title('Pessoas por Sexo');
        $personSexChart->label('Quantidade');
        $personSexChart->labels($personSex->keys());

        $cities = $personAll->countBy(fn (Person $person) => $person->address->district ?? 'Não informado');
        $citiesChart = new PersonChart;
        $citiesChart->dataset('Pessoas', 'line', $cities->values())
            ->options([
                'fill' => true,
                'borderColor' => '#51C1C0',
                'backgroundColor' => '#51C1C0',
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 2,
            ]);
        $citiesChart->title('Pessoas por Bairro');
        $citiesChart->label('Quantidade');
        $citiesChart->labels($cities->keys());

        return view('dash.dashboard',
            compact(
                'personChart',
                'demandChart',
                'demandChartType',
                'personSexChart',
                'citiesChart'
            )
        );
    }
}
