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
                        <a href="{{route('dash.person.create')}}"
                           class="btn btn-primary btn-sm ms-0 ms-md-2">Criar
                        </a>
                    @endcan
                    <button class="btn btn-primary btn-sm ms-0 ms-md-2 mx-1" type="button"
                            title="Filtrar elementos"
                            data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false"
                            {{(isset($page)&&$page>1)?'disabled':false}}
                            aria-controls="collapseExample">
                        Filtrar
                    </button>

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
                        <select wire:model="perPage" id="perPage" class="form-select"
                                title="Quantidade por página"
                        >
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

            <div
                wire:ignore.self
                class="collapse"
                id="collapseFilter">
                <div class="card card-body">
                    <div class="form-inline">
                        <label>
                            Bairro
                            <input name="district" wire:model.debounce.500ms="filter.district" class="form-control-sm">
                        </label>
                        <label>
                            Cidade
                            <input name="city" wire:model.debounce.500ms="filter.city" class="form-control-sm">
                        </label>
                        <label>
                            E-mail
                            <input name="email" wire:model.debounce.500ms="filter.email" class="form-control-sm">
                        </label>
                        <label>
                            Telefone
                            <input name="phone" wire:model.debounce.500ms="filter.telephone" class="form-control-sm">
                        </label>
                        <label>
                            Celular
                            <input name="cellphone" wire:model.debounce.500ms="filter.cellphone"
                                   class="form-control-sm">
                        </label>
                    </div>
                    <button
                        class="btn btn-sm btn-primary"
                        wire:click="resetFilter"
                    >
                        Limpar
                    </button>
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

                    {{--                    <th>--}}
                    {{--                        <x-table-column name="email" title="Email" :defaultReorderColumn="$defaultReorderColumn"--}}
                    {{--                                        :defaultReorderASC="$defaultReorderASC"/>--}}
                    {{--                    </th>--}}
                    <th>
                        <x-table-column name="cellphone" title="Celular" :defaultReorderColumn="$defaultReorderColumn"
                                        :defaultReorderASC="$defaultReorderASC"/>
                    </th>
                    <th>
                        <x-table-column name="cpf" title="CPF" :defaultReorderColumn="$defaultReorderColumn"
                                        :defaultReorderASC="$defaultReorderASC"/>
                    </th>
                    <th>
                        <div class="d-flex align-items-center" style="cursor:pointer;">
                            <span>Endereço</span>
                        </div>
                    </th>
                    <th width="150px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($people as $person)
                    <tr>
                        @if($bulkActionsEnabled??false)
                            <td>
                                <div class="form-check">
                                    <input wire:loading.attr.delay="disabled" value="{{$person->id}}" type="checkbox"
                                           wire:click="setSelected({{$person->id}})"
                                           class="form-check-input" {{$selectAll?'checked':''}} />
                                </div>
                            </td>
                        @endif
                        <td>{{ $person->name }}</td>
                        {{--                        <td>{{ $person->email }}</td>--}}
                        <td>{{ $person->cellphone?->format() }}</td>
                        <td>{{ $person->cpf }}</td>
                        <td>{{ $person->address?->street }}, {{ $person->address?->district }}</td>
                        <td class="d-flex">
                            <a href="{{route('dash.person.show',$person->pid)}}" class="btn btn-black btn-sm m-1">
                                Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <x-table-pagination :items="$people" :per-page="$perPage"/>
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
