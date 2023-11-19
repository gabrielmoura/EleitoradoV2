<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-user-shield fa-lg"></i>
                        </div>
                        Usuários
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <a class="btn btn-lg btn-success" href="{{route('dash.user.create')}}">Cadastrar Novo</a>
        <table id="dataTable" class="table table-striped table-bordered display nowrap" cellspacing="0">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Role</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Role</th>
                <th>Ação</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        {{$user?->birthday?->month == now()->month? '🎂🎉':''}}
                        {{$user->name}}
                    </td>
                    <td>{{$user->email}}</td>
                    <td>
                        <span
                            class="badge bg-blue">{{\App\Service\Enum\RoleOptions::getRoleOption($user->roles->first()->name)}}</span>
                        @if($user->banned_at!= null)
                            <span class="badge bg-danger">BAN</span>
                        @endif
                    </td>
                    <td>
                        @if($user->banned_at== null)
                            <button class="btn btn-warning" type="button" onclick="helpers.banUser({{$user->id}})">
                                Banir
                            </button>
                        @else
                            <button class="btn btn-warning" type="button" onclick="helpers.unBanUser({{$user->id}})">
                                Desbanir
                            </button>
                        @endif
                        <a class="btn btn-secondary" href="{{route('dash.user.edit',['user'=>$user->id])}}">Editar</a>
                        <a class="btn btn-primary" href="{{route('dash.user.show',['user'=>$user->id])}}">Ver</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    </div>
</x-app-layout>
