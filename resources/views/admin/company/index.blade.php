<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-industry-alt fa-lg"></i>
                        </div>
                        Empresas
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="row">
            <div class="col-md-12 ">
                <div class="d-md-flex justify-content-between mb-3">
                    <div class="d-md-flex">
                        <div class="mb-3 mb-md-0 input-group">
                        </div>
                        <a href="{{route('admin.company.create')}}"
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
                    @foreach($companies as $company)
                        <tr>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->description??null }}</td>
                            <td class="d-flex">
                                <a href="{{route('admin.company.show', $company->id)}}"
                                   class="btn btn-black btn-sm m-1">
                                    Ver
                                </a>

                                <a href="{{route('admin.company.edit', $company->id)}}}}"
                                   class="btn btn-primary btn-sm m-1">Edit
                                </a>

                                <button class="btn btn-danger btn-sm m-1">
                                    Desativar
                                </button>
                                <button class="btn btn-danger btn-sm m-1" data-bs-toggle="modal"
                                        data-bs-target="#createModal"
                                        onclick="document.getElementById('company_id').value = {{$company->id}}"
                                >
                                    Convidar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Criar Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="closeModal"></button>
                </div>
                <form action="{{route('admin.reqInviteTo')}}" method="POST">
                    @csrf
                    <input type="hidden" name="company_id" value="" id="company_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" class="form-control" id="email"/>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role">Função</label>
                            <select name="role" class="form-control" id="role">
                                @foreach(\App\Service\Enum\RoleOptions::getRoleOptions() as $key => $role)
                                    <option value="{{$role}}" @if($role=='admin') disabled @endif >{{$key}}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                                data-bs-dismiss="modal">Fechar
                        </button>
                        <button type="submit" class="btn btn-primary">Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
