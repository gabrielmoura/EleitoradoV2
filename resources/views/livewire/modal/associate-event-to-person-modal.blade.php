<div wire:ignore.self class="modal fade" id="associatePersonModal" tabindex="-1" aria-labelledby="createModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Associar Pessoa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
            </div>
            <div >
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Pessoa</label>

                        <select wire:loading.attr="disabled" multiple id="multiSelect" class="tomselected">
                            <option value="">Selecione</option>
                            @foreach($people as $person)
                                <option value="{{$person->id}}">{{$person->name}}</option>
                            @endforeach
                        </select>
                        @error('assoc') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-bs-dismiss="modal">Fechar
                    </button>
                    <button type="submit" class="btn btn-primary"
                            wire:loading.attr="disabled"
                            :disabled="$disabled" onclick="sendAssoc()">Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function sendAssoc() {
                Livewire.emit('multiSelectItemAdded', window.assoc)
                Livewire.emit('store')
            }
            document.addEventListener('DOMContentLoaded', function () {
                var multiSelect = new TomSelect("#multiSelect", {
                    plugins: ['dropdown_input', 'remove_button'],
                    create: true,
                    items: {!! json_encode($assoc) !!},
                });
                window.multiSelect = multiSelect;
                multiSelect.on('change', function (value) {
                    window.assoc = value;
                });
            });

        </script>
    @endpush
</div>
