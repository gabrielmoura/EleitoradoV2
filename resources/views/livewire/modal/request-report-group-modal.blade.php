<div wire:ignore.self class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="{{$modalId}}Label"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Solicitar relatório de pessoas por grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
            </div>
            <form wire:submit.prevent="store">
                <div class="modal-body">
                    @error('request') <span class="text-danger">{{ $message }}</span> @enderror
                    @if(empty($group_name))
                        <div class="mb-3">
                            <label for="data.group_name'">Grupo *</label>

                            <select wire:model.debounce.500ms="data.group_name" name="dato" class="form-select select"
                                    id="data.group_name'" multiple="multiple">
                                <option value="">Selecione</option>
                                @foreach($groups as $group)
                                    <option value="{{$group->name}}">{{$group->name}}</option>
                                @endforeach
                            </select>
                            @error('data.group_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="data.district">Bairro</label>
                        <input type="text" wire:model.debounce.500ms="data.district" class="form-control"
                               id="data.district">
                        @error('data.district') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="data.checked">Filtrar por Marcado</label>
                        <input type="checkbox" wire:model.debounce.500ms="data.checked" class="form-check-input"
                               id="data.checked">
                        @error('data.checked') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-bs-dismiss="modal">Fechar
                    </button>
                    <button type="submit" class="btn btn-primary"
                            wire:target="store"
                            wire:loading.attr="disabled"
                            :disabled="$disabled">Solicitar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
