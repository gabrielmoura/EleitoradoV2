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
