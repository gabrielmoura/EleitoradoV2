<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <h2 class="h4 font-weight-bold">
                    Usuários
                </h2>
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
            @foreach($users as $event)
                <tr>
                    <td>{{$event->name}}</td>
                    <td>{{$event->email}}</td>
                    <td>
                        <span class="badge badge-danger">{{$event->roles->first()->name}}</span>
                    </td>
                    <td>
                        <button class="btn btn-warning">Banir</button>
                        <button class="btn btn-secondary">Editar</button>
                        <button class="btn btn-primary">Ver</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
