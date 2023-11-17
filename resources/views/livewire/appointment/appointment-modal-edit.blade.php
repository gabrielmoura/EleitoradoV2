<div wire:ignore.self class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="{{$modalId}}Label"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Solicitar etiquetas de eventos com endereços</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
            </div>
            <form wire:submit.prevent="store">
                <div class="modal-body">
                    @error('request') <span class="text-danger">{{ $message }}</span> @enderror

{{--                    @if(empty($event_id))--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="data.event_id">Evento *</label>--}}

{{--                            <select wire:model.debounce.500ms="data.event_id" name="dato" class="form-select select"--}}
{{--                                    id="data.event_id">--}}
{{--                                <option value="">Selecione</option>--}}
{{--                                @foreach($events as $event)--}}
{{--                                    <option value="{{$event->id}}">{{$event->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('data.event_id') <span class="text-danger">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                    @endif--}}

                    <div class="mb-3">
                        <label for="data.type">Tipo</label>

                        <select wire:model.debounce.500ms="data.type" name="dato" class="form-select select"
                                id="data.type">
                            <option value="">Selecione</option>
                            <option value="">Padrão</option>

                        </select>
                        @error('data.type') <span class="text-danger">{{ $message }}</span> @enderror
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
