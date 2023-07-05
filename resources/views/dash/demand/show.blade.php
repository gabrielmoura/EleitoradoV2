<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="me-1 far fa-calendar-alt"></i>
                        </div>
                        Demanda: {{$demand->name}}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{route('dash.demand.index')}}">
                        <i class="me-1 far fa-calendar-alt"></i>
                        Listar Demandas
                    </a>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="card">
            <div class="card-header">
                {{$demand->name}}
            </div>
            <div class="card-body">
                <dl>
                    <dd>Prioridade: {{\App\Service\Enum\DemandOptions::getPriorityOption($demand->priority)}}</dd>
                    <dd>Status: {{\App\Service\Enum\DemandOptions::getStatusOption($demand->status)}}</dd>
                    <dd>Tipo: {{$demand->type->name}}</dd>
                    <dd>Sata para Solução: {{$demand->solution_date?->format('d/m/y H:i')}}</dd>
                    <dd>Fechado Em: {{$demand->closed_at?->format('d/m/y H:i')}}</dd>
                    <dd>Descrição: {{$demand->description}}</dd>
                </dl>
            </div>
        </div>

        <div class="card mt-1">
            <div class="card-header">
                Pessoas Associadas
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    @forelse($demand->persons as $person)
                        <tr>
                            <td>
                                <a href="{{route('dash.person.show', $person->pid)}}">
                                    <i class="far fa-user"></i>
                                    {{$person->name}}
                                </a>
                            </td>
                        </tr>
                    @empty
                        Nenhuma pessoa associada
                    @endforelse
                </table>
            </div>
        </div>

    </div>

</x-app-layout>
