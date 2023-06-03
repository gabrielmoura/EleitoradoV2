<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event') }}
        </h2>
    </x-slot>

    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-12 ">
                <div class="d-md-flex justify-content-between mb-3">
                    <div class="d-md-flex">
                        <div class="mb-3 mb-md-0 input-group">
                            <input wire:model="search" placeholder="Search" type="text" class="form-control"/>
                        </div>
                        @can('create_event')
                            <button data-bs-toggle="modal" data-bs-target="#createModal"
                                    class="btn btn-primary btn-sm ms-0 ms-md-2">Criar
                            </button>
                        @endcan
                    </div>

                    <div class="d-md-flex">

                        <div x-show="selectedItems.length > 0" class="mb-3 mb-md-0" style="display: none;">
                            <div class="dropdown d-block d-md-inline">
                                <button class="btn dropdown-toggle d-block w-100 d-md-inline" type="button"
                                        id="table-bulkActionsDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
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

                        {{--                        <div class=" mb-3 mb-md-0 md-0 ms-md-2">--}}
                        {{--                            <div x-data="{ open: false, childElementOpen: false }"--}}
                        {{--                                 x-on:keydown.escape.stop="if (!childElementOpen) { open = false }"--}}
                        {{--                                 x-on:mousedown.away="if (!childElementOpen) { open = false }"--}}
                        {{--                                 class="dropdown d-block d-md-inline" wire:key="column-select-button-table">--}}
                        {{--                                <button x-on:click="open = !open" class="btn dropdown-toggle d-block w-100 d-md-inline"--}}
                        {{--                                        type="button" id="columnSelect-table" aria-haspopup="true"--}}
                        {{--                                        x-bind:aria-expanded="open" aria-expanded="false">--}}
                        {{--                                    Columns--}}
                        {{--                                </button>--}}

                        {{--                                <div class="dropdown-menu dropdown-menu-end w-100" x-bind:class="{ 'show': open }"--}}
                        {{--                                     aria-labelledby="columnSelect-table" style="display: none">--}}
                        {{--                                    <div class="form-check ms-2">--}}
                        {{--                                        <input checked="" wire:click="deselectAllColumns" wire:loading.attr="disabled"--}}
                        {{--                                               type="checkbox" class="form-check-input">--}}
                        {{--                                        <label wire:loading.attr="disabled" class="form-check-label">--}}
                        {{--                                            All Columns--}}
                        {{--                                        </label>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div wire:key="columnSelect-0-table" class="form-check ms-2">--}}
                        {{--                                        <input wire:model="selectedColumns" wire:target="selectedColumns"--}}
                        {{--                                               wire:loading.attr="disabled" type="checkbox" class="form-check-input"--}}
                        {{--                                               value="id">--}}
                        {{--                                        <label wire:loading.attr="disabled" wire:target="selectedColumns"--}}
                        {{--                                               class="mb-1 form-check-label">Id</label>--}}


                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

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
                        <th scope="col" class="">
                            <div class="d-flex align-items-center" wire:click="sortBy('name')" wire:change="orderBy"
                                 wire:change="orderAsc" style="cursor:pointer;">
                                <span>Nome</span>
                            </div>
                        </th>
                        <th>Descrição</th>
                        <th scope="col" class="">
                            <div class="d-flex align-items-center" wire:click="sortBy('start_date')"
                                 wire:change="orderBy"
                                 wire:change="orderAsc" style="cursor:pointer;">
                                <span>Inicio</span>
                            </div>
                        </th>
                        <th scope="col" class="">
                            <div class="d-flex align-items-center" wire:click="sortBy('end_date')" wire:change="orderBy"
                                 wire:change="orderAsc" style="cursor:pointer;">
                                <span>Fim</span>
                            </div>
                        </th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->description }}</td>
                            <td>{{ $event->start_date }}</td>
                            <td>{{ $event->end_date }}</td>
                            <td class="d-flex">
                                @can('update_event')
                                    <button data-bs-toggle="modal" data-bs-target="#updateModal"
                                            wire:click="edit({{$event->id}})" class="btn btn-primary btn-sm m-1">Edit
                                    </button>
                                @endcan
                                @can('delete_event')
                                    <button wire:click="delete({{ $event->id }})" class="btn btn-danger btn-sm m-1">
                                        Delete
                                    </button>
                                @endcan
                                <a href="/dash/event/{{$event->pid}}/history" class="btn btn-black btn-sm m-1">
                                    Histórico
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-md-flex justify-content-between">
                    Showing {{count($events)}} results
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Create Modal -->
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Criar Evento</h5>
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
                            <label>Inicio</label>
                            <input type="datetime-local" wire:model.debounce.500ms="start_date" class="form-control">
                            @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Fim</label>
                            <input type="datetime-local" wire:model.debounce.500ms="end_date" class="form-control">
                            @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                                data-bs-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary"
                                wire:target="store"
                                wire:loading.attr="disabled"
                                :disabled="$disabled">Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Editar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                            aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="update">
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
                            <label>Inicio</label>
                            <input type="datetime-local" wire:model.debounce.500ms="start_date" class="form-control">
                            @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Fim</label>
                            <input type="datetime-local" wire:model.debounce.500ms="end_date" class="form-control">
                            @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                                data-bs-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary"
                                wire:target="update"
                                wire:loading.attr="disabled"
                                :disabled="$disabled">Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
