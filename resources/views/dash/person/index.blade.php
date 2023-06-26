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
                        Pessoas
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <a class="btn btn-lg btn-success" href="{{route('dash.person.create')}}">Cadastrar Novo</a>
        <livewire:person.index></livewire:person.index>
{{--        <livewire:person-table></livewire:person-table>--}}
    </div>
    {{--    <div class="bgc-white bd bdrs-3 p-20 mB-20">--}}
    {{--        <a class="btn btn-lg btn-success" href="{{route('dash.voter.create')}}">Cadastrar Novo</a>--}}
    {{--        <table id="dataTable" class="table table-striped table-bordered display nowrap" cellspacing="0">--}}
    {{--            <thead>--}}
    {{--            <tr>--}}
    {{--                <th>Nome</th>--}}
    {{--                <th>Tel</th>--}}
    {{--                <th>Cel</th>--}}
    {{--                <th>CPF</th>--}}
    {{--                <th>Sexo</th>--}}
    {{--                <th>Logradouro</th>--}}
    {{--                <th>Data de Nascimento</th>--}}
    {{--                <th>Ação</th>--}}

    {{--            </tr>--}}
    {{--            </thead>--}}
    {{--            <tfoot>--}}
    {{--            <tr>--}}
    {{--                <th>Nome</th>--}}
    {{--                <th>Tel</th>--}}
    {{--                <th>Cel</th>--}}
    {{--                <th>CPF</th>--}}
    {{--                <th>Sexo</th>--}}
    {{--                <th>Logradouro</th>--}}
    {{--                <th>Data de Nascimento</th>--}}
    {{--                <th>Ação</th>--}}
    {{--            </tr>--}}
    {{--            </tfoot>--}}
    {{--            <tbody>--}}
    {{--            @foreach($voters as $voter)--}}
    {{--                <tr>--}}
    {{--                    <td>{{$voter->name}}</td>--}}
    {{--                    <td>{{$voter->tel}}</td>--}}
    {{--                    <td>{{$voter->cel}}</td>--}}
    {{--                    <td>{{$voter->cpf}}</td>--}}
    {{--                    <td>{{$voter->sex}}</td>--}}
    {{--                    <td>{{$voter->address->street??null}}</td>--}}
    {{--                    <td>{{$voter->birth_date}}</td>--}}
    {{--                    <td>--}}
    {{--                        <a href="{{route('dash.voter.show',['voter'=>$voter->pid])}}">--}}
    {{--                            <span class="badge bg-primary"><i class="fa fa-eye"></i> Ver</span>--}}
    {{--                        </a>--}}

    {{--                        <a href="{{route('dash.voter.edit',['voter'=>$voter->pid])}}">--}}
    {{--                            <span class="badge bg-primary"><i class="fa fa-edit"></i> Editar</span>--}}
    {{--                        </a>--}}
    {{--                        <a href="{{route('dash.voter.history',['voter'=>$voter->pid])}}">--}}
    {{--                            <span class="badge bg-primary"><i class="fa fa-book"></i> Histórico</span>--}}
    {{--                        </a>--}}
    {{--                        @hasrole('manager')--}}
    {{--                        <form action="{{route('dash.voter.destroy',['voter'=>$voter->pid])}}" method="POST">--}}
    {{--                            @csrf--}}
    {{--                            @method('DELETE')--}}
    {{--                            <button type="submit">Remover</button>--}}
    {{--                        </form>--}}
    {{--                        @endhasrole--}}
    {{--                    </td>--}}
    {{--                </tr>--}}
    {{--            @endforeach--}}
    {{--            </tbody>--}}
    {{--        </table>--}}
    {{--    </div>--}}
</x-app-layout>
