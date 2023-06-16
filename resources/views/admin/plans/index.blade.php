<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-money-check-edit fa-lg"></i>
                        </div>
                        Planos
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-12 ">
                <div class="d-md-flex justify-content-between mb-3">
                    <div class="d-md-flex">
                        <div class="mb-3 mb-md-0 input-group">
                        </div>
                        <a href="{{route('admin.plan.create')}}"
                           class="btn btn-primary btn-sm ms-0 ms-md-2">Criar
                        </a>
                    </div>

                    <div class="d-md-flex">
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>

                        <th scope="col" class="">
                            <div class="d-flex align-items-center">
                                <span>Nome</span>
                            </div>
                        </th>
                        <th>Descrição</th>
                        <th width="150px">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($plans as $plan)
                        <tr>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->description }}</td>
                            <td class="d-flex">
                                <a href="{{route('admin.plan.show', $plan->slug)}}"
                                   class="btn btn-black btn-sm m-1">
                                    Ver
                                </a>

                                <a href="{{route('admin.plan.edit', $plan->slug)}}}}"
                                   class="btn btn-primary btn-sm m-1">Edit
                                </a>

                                <button class="btn btn-danger btn-sm m-1">
                                    Desativar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>

</x-app-layout>
