<div class="container">
    <br>
    <div class="row">
        <div class="col-md-12 ">
            <div class="d-md-flex justify-content-between mb-3">
                <div class="d-md-flex">
                    <div class="mb-3 mb-md-0 input-group">
                        <input wire:model="search" placeholder="Search" type="text" class="form-control"/>
                    </div>
                    @can('create_group')
                        <button data-bs-toggle="modal" data-bs-target="#createModal"
                                class="btn btn-primary btn-sm ms-0 ms-md-2">Criar
                        </button>
                    @endcan
                </div>

                <div class="d-md-flex">
                    @if(($bulkActionsEnabled??false) && $selected>0)
                        <div class="mb-3 mb-md-0">
                            <div class="dropdown d-block d-md-inline">
                                <button class="btn dropdown-toggle d-block w-100 d-md-inline" type="button"
                                        id="table-bulkActionsDropdown" data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    Bulk Actions
                                </button>

                                <div class="dropdown-menu dropdown-menu-end w-100"
                                     aria-labelledby="table-bulkActionsDropdown">
                                    <a href="#" wire:click.prevent="exportSelected('csv')"
                                       wire:key="bulk-action-exportSelected-table" class="dropdown-item">
                                        Export
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="ms-0 ms-md-2">
                        <select wire:model="perPage" id="perPage" title="Quantidade por página" class="form-select">
                            <option value="10">
                                10
                            </option>
                            <option value="25">
                                25
                            </option>
                            <option value="50">
                                50
                            </option>
                        </select>
                    </div>

                </div>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    {{--                        <th>No.</th>--}}
                    @if($bulkActionsEnabled??false)
                        <th>
                            <div class="form-check">
                                <input wire:loading.attr.delay="disabled" type="checkbox" wire:click="selectAll"
                                       class="form-check-input"/>
                            </div>
                        </th>
                    @endif
                    <th scope="col" class="">
                        <x-table-column name="name" title="Nome" :defaultReorderColumn="$defaultReorderColumn"
                                        :defaultReorderASC="$defaultReorderASC"/>
                    </th>
                    <th>
                        <x-table-column name="description" title="Descrição"
                                        :defaultReorderColumn="$defaultReorderColumn"
                                        :defaultReorderASC="$defaultReorderASC"/>
                    </th>
                    <th width="150px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        @if($bulkActionsEnabled??false)
                            <td>
                                <div class="form-check">
                                    <input wire:loading.attr.delay="disabled" value="{{$group->id}}" type="checkbox"
                                           wire:click="setSelected({{$group->id}})"
                                           class="form-check-input" {{$selectAll?'checked':''}} />
                                </div>
                            </td>
                        @endif
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->description }}</td>
                        <td class="d-flex">
                            <a href="/dash/group/{{$group->pid}}" class="btn btn-black btn-sm m-1">
                                Ver
                            </a>
                            @can('update_group')
                                <button data-bs-toggle="modal" data-bs-target="#updateModal"
                                        wire:click="edit({{$group->id}})" class="btn btn-primary btn-sm m-1">Editar
                                </button>
                            @endcan
                            @can('delete_group')
                                <button wire:click="delete({{ $group->id }})" class="btn btn-danger btn-sm m-1">
                                    Deletar
                                </button>
                            @endcan
                            <a href="{{route('dash.group.history',$group->pid)}}" class="btn btn-black btn-sm m-1">
                                Histórico
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <x-table-pagination :items="$groups" :per-page="$perPage"/>
        </div>
    </div>

    @can('create_group')
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
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nome</label>
                                <input type="text" wire:model.debounce.500ms="name" class="form-control">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Descrição</label>
                                <input type="text" wire:model.debounce.500ms="description" class="form-control">
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal"
                                    data-bs-dismiss="modal">Fechar
                            </button>
                            <button type="submit" class="btn btn-primary"
                                    wire:target="store"
                                    wire:loading.attr="disabled"
                                    :disabled="$disabled">Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @can('update_group')
        <!-- Update Modal -->
        <div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Atualizar Grupo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                                aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="update">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nome</label>
                                <input type="text" wire:model="name" class="form-control">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Descrição</label>
                                <input type="text" wire:model="description" class="form-control">
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal"
                                    data-bs-dismiss="modal">Fechar
                            </button>
                            <button type="submit" class="btn btn-primary"
                                    wire:target="update"
                                    wire:loading.attr="disabled"
                                    :disabled="$disabled">Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
</div>


