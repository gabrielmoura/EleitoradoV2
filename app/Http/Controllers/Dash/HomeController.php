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
    private function getChartOptions(string $color): array
    {
        return [
            'fill' => true,
            'borderColor' => $color,
            'backgroundColor' => $color,
            'borderWidth' => 2,
            'pointRadius' => 2,
            'pointHoverRadius' => 2,
        ];
    }

    private function getDemandTypeData($demand): array
    {
        return $demand->pluck('type')->groupBy(fn ($date) => $date->name)->map(fn ($item) => $item->count())->values()->toArray();
    }

    private function getDemandTypeLabels($demand): array
    {
        return $demand->pluck('type')->groupBy(fn ($date) => $date->name)->map(fn ($item) => $item->count())->keys()->toArray();
    }

    public function __invoke(Request $request)
    {
        $labels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        $personAlly = Person::with('address')->getYears(now()->year)->totalByMonth();
        $groupAlly = Group::getYears(now()->year)->totalByMonth();
        $demandAlly = Demand::getYears(now()->year)->totalByMonth();

        // DemandType by type
        $personAll = Person::with('address')->orderBy('created_at')->get();
        $demand = Demand::with('type')->orderBy('created_at')->get();

        $personChart = new PersonChart;

        $personChart->dataset('Pessoas', 'line', $personAlly)->options($this->getChartOptions('#51C1C0'));

        $personChart->dataset('Grupos', 'line', $groupAlly)->options($this->getChartOptions('#FECB2E'));

        $personChart->labels($labels)->title('Pessoas e Grupos');

        // Contagem de demandas por mês
        $demandChart = new DemandsCompletedChart;
        $demandChart->dataset('Demandas', 'line', $demandAlly)->options($this->getChartOptions('#51C1C0'));
        $demandChart->labels($labels)->title('Demandas');

        $demandChartType = new DemandsCompletedChart;
        $demandChartType->dataset('Demandas', 'line', $this->getDemandTypeData($demand))->options($this->getChartOptions('#51C1C0'));
        $demandChartType->labels($this->getDemandTypeLabels($demand))->title('Demandas por Tipo');

        // Contagem de pessoas por sexo
        $personSex = $personAll->countBy(fn (Person $person) => PersonOptions::getSexOption($person->sex));
        $personSexChart = new PersonChart;
        $personSexChart->dataset('Pessoas', 'pie', $personSex->values())->options($this->getChartOptions('#51C1C0'));
        $personSexChart->title('Pessoas por Sexo')->label('Quantidade')->labels($personSex->keys());

        // Contagem de pessoas por bairro
        $cities = $personAll->countBy(fn (Person $person) => $person->address->district ?? 'Não informado');
        $citiesChart = new PersonChart;
        $citiesChart->dataset('Pessoas', 'line', $cities->values())->options($this->getChartOptions('#51C1C0'));
        $citiesChart->title('Pessoas por Bairro')->label('Quantidade')->labels($cities->keys());

        return view('dash.dashboard', compact(
            'personChart',
            'demandChart',
            'demandChartType',
            'personSexChart',
            'citiesChart'
        ));
    }
}
