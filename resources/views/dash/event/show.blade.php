<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        Evento: {{$event->name}}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{route('dash.event.index')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-users me-1">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Listar Eventos
                    </a>
                    {{--            <a class="btn btn-sm btn-light text-primary" href="{{route('dash.event.history',['event'=>$event->pid])}}">--}}
                    {{--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"--}}
                    {{--                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"--}}
                    {{--                     class="feather feather-user-plus me-1">--}}
                    {{--                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>--}}
                    {{--                    <circle cx="8.5" cy="7" r="4"></circle>--}}
                    {{--                    <line x1="20" y1="8" x2="20" y2="14"></line>--}}
                    {{--                    <line x1="23" y1="11" x2="17" y2="11"></line>--}}
                    {{--                </svg>--}}
                    {{--                Histórico--}}
                    {{--            </a>--}}
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="card">
            <div class="card-header">
                <h3 class="text-start text-xl">{{$event->name}}</h3>
                <div class="text-end">
                    {{--                    <button class="btn btn-sm btn-blue" onclick="helpers.requestReportGroup('{{$event->name}}')">Puxada</button>--}}
                </div>
                {{--                <div class="text-end">--}}
                {{--                    <a href="" class="btn btn-primary btn-sm">Editar</a>--}}
                {{--                    <a href="" class="btn btn-secondary btn-sm">Voltar</a>--}}
                {{--                </div>--}}
            </div>
            <div class="card-body m-3">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Descrição</h3>
                        <p>{{$event->description}}</p>
                    </div>

                    <div class="col-md-6">
                        <h3>Data de Início</h3>
                        <p>{{$event->start_date->format('d/m/y H:i')}}</p>
                        <h3>Data de Término</h3>
                        <p>{{$event->end_date?->format('d/m/y H:i')}}</p>
                        <h3>Endereço</h3>
                        <p>{{$event->address->street}}, {{$event->address->number}} - {{$event->address->district}}
                            - {{$event->address->city}}/{{$event->address->state}}</p>

                        @feature('event_group')
                        <h3>Grupo</h3>
                        <p>{{$event->group->name}}</p>
                        @endfeature
                        @feature('event_demand')
                        <h3>Demanda</h3>
                        <p>{{$event->demands->name}}</p>
                        @endfeature
                    </div>
                </div>
                <div class="row">
                    <h3>Estimativa de Público</h3>
                    <p>{{$event->estimated_public??'0'}}</p>
                    <h3>Quantidade de Pessoas</h3>
                    <p>{{$event->persons->count()}}</p>
                </div>
                <div class="row">

                    <h3>Pessoas Associadas</h3>
                    <table class="table table-responsive-md table-bordered ml-3">
                        <tbody>
                        @forelse($event->persons as $person)
                            <tr>
                                <td>{{$person->name}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td>Nenhuma Pessoa encontrada</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
