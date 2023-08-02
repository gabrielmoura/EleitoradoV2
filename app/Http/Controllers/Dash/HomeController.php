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
        $labels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        $personAlly = Person::with('address')->getYears(date('Y'))->totalByMonth();
        $groupAlly = Group::getYears(date('Y'))->totalByMonth();
        $demandAlly = Demand::getYears(date('Y'))->totalByMonth();
        // DemandType by type

        $personAll = Person::with('address')->orderBy('created_at')->get();
        $demand = Demand::with('type')
            ->orderBy('created_at')->get();

        $personChart = new PersonChart;

        $personChart->dataset('Pessoas', 'line', $personAlly)
            ->options([
                'fill' => true,
                'borderColor' => '#51C1C0',
                'backgroundColor' => '#51C1C0',
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 2,
            ]);

        $personChart->dataset('Grupos', 'line', $groupAlly)
            ->options([
                'fill' => true,
                'borderColor' => '#FECB2E',
                'backgroundColor' => '#FECB2E',
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 2,
            ]);

        $personChart->labels($labels);
        $personChart->title('Pessoas e Grupos');

        // Contagem de demandas por mês
        $demandChart = new DemandsCompletedChart;
        $demandChart->dataset(
            'Demandas',
            'line',
            $demandAlly
        )
            ->options([
                'fill' => true,
                'borderColor' => '#51C1C0',
                'backgroundColor' => '#51C1C0',
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 2,
            ]);
        $demandChart->labels($labels);
        $demandChart->title('Demandas');

        $demandChartType = new DemandsCompletedChart;
        $demandChartType->dataset(
            name: 'Demandas',
            type: 'line',
            data: $demand->pluck('type')
                ->groupBy(fn($date) => $date->name)
                ->map(fn($item) => $item->count())
                ->values()
        )->options([
            'fill' => true,
            'borderColor' => '#51C1C0',
            'backgroundColor' => '#51C1C0',
            'borderWidth' => 2,
            'pointRadius' => 2,
            'pointHoverRadius' => 2,
        ]);
        $demandChartType->labels($demand->pluck('type')->groupBy(fn($date) => $date->name)->map(fn($item) => $item->count())->keys());
        $demandChartType->title('Demandas por Tipo');

        // Contagem de pessoas por sexo
        $personSex = $personAll->countBy(fn(Person $person) => PersonOptions::getSexOption($person->sex));
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

        $cities = $personAll->countBy(fn(Person $person) => $person->address->district ?? 'Não informado');
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
