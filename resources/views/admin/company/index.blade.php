<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Eventos') }}
        </h2>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <a class="btn btn-lg btn-success" href="{{route('dash.event.create')}}">Cadastrar Novo</a>
        <table id="dataTable" class="table table-striped table-bordered display nowrap" cellspacing="0">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Inicio</th>
                <th>Fim</th>
                <th>Descrição</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nome</th>
                <th>Inicio</th>
                <th>Fim</th>
                <th>Descrição</th>
                <th>Ação</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{$event->name}}</td>
                    <td>{{$event->start_time}}</td>
                    <td>{{$event->end_time}}</td>
                    <td>{{$event->description}}</td>

                    <td>
                        <a href="{{route('dash.event.show',['event'=>$event->pid])}}">
                            <span class="badge bg-primary"><i class="fa fa-eye"></i> Ver</span>
                        </a>

                        <a href="{{route('dash.event.edit',['event'=>$event->pid])}}">
                            <span class="badge bg-primary"><i class="fa fa-edit"></i> Editar</span>
                        </a>

                        @hasrole('manager')
                        <form action="{{route('dash.event.destroy',['event'=>$event->pid])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remover</button>
                        </form>
                        @endhasrole
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
