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
                        Grupo: {{$group->name}}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{route('dash.group.index')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-users me-1">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Listar Grupos
                    </a>
                    <a class="btn btn-sm btn-light text-primary"
                       href="{{route('dash.group.history',['group'=>$group->pid])}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-user-plus me-1">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                        Histórico
                    </a>
                    <button class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#request-report-group-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-user-plus me-1">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                        Puxada
                    </button>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="card">
            <div class="card-header">
                <h3 class="text-start text-xl">{{$group->name}}</h3>
                <div class="text-end">
                </div>
                {{--                <div class="text-end">--}}
                {{--                    <a href="" class="btn btn-primary btn-sm">Editar</a>--}}
                {{--                    <a href="" class="btn btn-secondary btn-sm">Voltar</a>--}}
                {{--                </div>--}}
            </div>
            <div class="card-body m-3">
                <div class="row">
                    <h3>Descrição</h3>
                    <p>{{$group->description}}</p>
                    <h3>Quantidade de Pessoas</h3>
                    <p>{{$persons->total()}}</p>
                </div>
                <div class="row">

                    <h3>Pessoas Associadas</h3>
                    <table class="table table-responsive-md table-bordered ml-3">
                        <tbody>
                        @forelse($persons as $person)
                            <tr>
                                <td>
                                    <a href="{{route('dash.person.show',['person'=>$person->pid])}}">
                                        <i class="fad fa-user me-1"></i>
                                        {{$person->name}}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>Nenhuma Pessoa encontrada</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{$persons->links('vendor.pagination.bootstrap-5')}}
                </div>
            </div>
        </div>
    </div>
    <livewire:modal.request-report-group-modal :group_name="$group->name"/>
</x-app-layout>
