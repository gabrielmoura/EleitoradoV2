<div class="container">
    <br>
    <div class="row">
        <div class="col-md-12 ">
            <div class="d-md-flex justify-content-between mb-3">
                <div class="d-md-flex">
                    <div class="mb-3 mb-md-0 input-group">
                        <input wire:model="search" placeholder="Search" type="text" class="form-control"/>
                    </div>
                    @can('create_demand_type')
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

                    <div class=" mb-3 mb-md-0 md-0 ms-md-2">
                        <div x-data="{ open: false, childElementOpen: false }"
                             x-on:keydown.escape.stop="if (!childElementOpen) { open = false }"
                             x-on:mousedown.away="if (!childElementOpen) { open = false }"
                             class="dropdown d-block d-md-inline" wire:key="column-select-button-table">
                            <button x-on:click="open = !open" class="btn dropdown-toggle d-block w-100 d-md-inline"
                                    type="button" id="columnSelect-table" aria-haspopup="true"
                                    x-bind:aria-expanded="open" aria-expanded="false">
                                Columns
                            </button>

                            <div class="dropdown-menu dropdown-menu-end w-100" x-bind:class="{ 'show': open }"
                                 aria-labelledby="columnSelect-table">
                                <div class="form-check ms-2">
                                    <input checked="" wire:click="deselectAllColumns" wire:loading.attr="disabled"
                                           type="checkbox" class="form-check-input">
                                    <label wire:loading.attr="disabled" class="form-check-label">
                                        All Columns
                                    </label>
                                </div>
                                <div wire:key="columnSelect-0-table" class="form-check ms-2">
                                    <input wire:model="selectedColumns" wire:target="selectedColumns"
                                           wire:loading.attr="disabled" type="checkbox" class="form-check-input"
                                           value="id">
                                    <label wire:loading.attr="disabled" wire:target="selectedColumns"
                                           class="mb-1 form-check-label">Id</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ms-0 ms-md-2">
                        <select wire:model="perPage" id="perPage" class="form-select">
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
                        <div class="d-flex align-items-center" wire:click="orderBy('name')" wire:change="orderBy"
                             wire:change="orderAsc" style="cursor:pointer;">
                            <span>Nome</span>
                        </div>
                    </th>
                    <th scope="col" class="">
                        <div class="d-flex align-items-center" wire:click="orderBy('priority')"
                             wire:change="orderBy"
                             wire:change="orderAsc" style="cursor:pointer;">
                            <span>Prioridade</span>
                        </div>
                    </th>
                    <th scope="col" class="">
                        <div class="d-flex align-items-center" wire:click="orderBy('status')"
                             wire:change="orderBy"
                             wire:change="orderAsc" style="cursor:pointer;">
                            <span>Status</span>
                        </div>
                    </th>
                    <th scope="col" class="">
                        <div class="d-flex align-items-center" wire:click="orderBy('solution_date')"
                             wire:change="orderBy"
                             wire:change="orderAsc" style="cursor:pointer;">
                            <span>Data de Solução</span>
                        </div>
                    </th>
                    <th scope="col" class="">
                        <div class="d-flex align-items-center" wire:click="orderBy('closed_at')"
                             wire:change="orderBy"
                             wire:change="orderAsc" style="cursor:pointer;">
                            <span>Data de Fechamento</span>
                        </div>
                    </th>
                    <th scope="col" class="">
                        <div class="d-flex align-items-center" wire:click="orderBy('demand_type_id')"
                             wire:change="orderBy"
                             wire:change="orderAsc" style="cursor:pointer;">
                            <span>Tipo de Demanda</span>
                        </div>
                    </th>
                    <th width="150px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($demands as $group)
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
                        <td>{{\App\Service\Enum\DemandOptions::getPriorityOption($group->priority)}}</td>
                        <td>{{\App\Service\Enum\DemandOptions::getStatusOption($group->status)}}</td>
                        <td>{{ $group->solution_date?->format('d/m/Y') }}</td>
                        <td>{{ $group->closed_at?->format('d/m/Y') }}</td>
                        <td>{{ $group->type->name }}</td>
                        <td class="d-flex">
                            <a href="{{route('dash.demand.show',['demand'=>$group->pid])}}"
                               class="btn btn-black btn-sm m-1">
                                Ver
                            </a>
                            @can('update_demand_type')
                                <button data-bs-toggle="modal" data-bs-target="#updateModal"
                                        wire:click="edit('{{$group->pid}}')" class="btn btn-primary btn-sm m-1">Editar
                                </button>
                            @endcan
                            @can('delete_demand_type')
                                <button wire:click="delete('{{ $group->pid }}')" class="btn btn-danger btn-sm m-1">
                                    Deletar
                                </button>
                            @endcan
                            <a href="{{route('dash.demand.history',$group->pid)}}" class="btn btn-black btn-sm m-1">
                                Histórico
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <x-table-pagination :items="$demands" :per-page="$perPage"/>
        </div>
    </div>

    @can('create_demand_type')
        <!-- Create Modal -->
        <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="studentModalLabel">Criar Demanda</h5>
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
                            <div class="mb-3">
                                <label>Prioridade</label>
                                <select wire:model.debounce.500ms="priority" class="form-control">
                                    <option value="low">
                                        Baixa
                                    </option>
                                    <option value="medium">
                                        Média
                                    </option>
                                    <option value="high">
                                        Alta
                                    </option>
                                </select>
                                @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select wire:model.debounce.500ms="status" class="form-control">
                                    <option value="open">
                                        Aberto
                                    </option>
                                    <option value="closed">
                                        Fechado
                                    </option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Data de solução</label>
                                <input type="date" wire:model.debounce.500ms="solution_date" class="form-control">
                                @error('solution_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Data de fechamento</label>
                                <input type="date" wire:model.debounce.500ms="closed_at" class="form-control">
                                @error('closed_at') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Tipo de demanda</label>
                                <select wire:model.debounce.500ms="demand_type_id" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($demandTypes as $demandType)
                                        <option value="{{$demandType->id}}">
                                            {{$demandType->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('demand_type_id') <span class="text-danger">{{ $message }}</span> @enderror
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

    @can('update_demand_type')
        <!-- Update Modal -->
        <div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Editar Demanda</h5>
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
                                <input type="text" wire:model.debounce.500ms="description" class="form-control">
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Prioridade</label>
                                <select wire:model.debounce.500ms="priority" class="form-control">
                                    <option value="low">
                                        Baixa
                                    </option>
                                    <option value="medium">
                                        Média
                                    </option>
                                    <option value="high">
                                        Alta
                                    </option>
                                </select>
                                @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select wire:model.debounce.500ms="status" class="form-control">
                                    <option value="open">
                                        Aberto
                                    </option>
                                    <option value="closed">
                                        Fechado
                                    </option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Data de solução</label>
                                <input type="date" wire:model.debounce.500ms="solution_date" class="form-control">
                                @error('solution_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Data de fechamento</label>
                                <input type="date" wire:model.debounce.500ms="closed_at" class="form-control">
                                @error('closed_at') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Tipo de demanda</label>
                                <select wire:model.debounce.500ms="demand_type_id" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($demandTypes as $demandType)
                                        <option value="{{$demandType->id}}">
                                            {{$demandType->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('demand_type_id') <span class="text-danger">{{ $message }}</span> @enderror
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
