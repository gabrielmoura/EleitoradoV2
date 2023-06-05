<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Group') }}
        </h2>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="card">
            <div class="card-header">
                <h3 class="text-start text-xl">{{$group->name}}</h3>
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
                    <p>{{$group->persons->count()}}</p>
                </div>
                <div class="row">

                    <h3>Pessoas Associadas</h3>
                    <table class="table table-responsive-md table-bordered ml-3">
                        <tbody>
                        @forelse($group->persons as $person)
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
