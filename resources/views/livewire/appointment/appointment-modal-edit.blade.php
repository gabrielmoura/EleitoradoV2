<div wire:ignore.self class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="{{$modalId}}Label"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Editar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
            </div>
            <form wire:submit.prevent="update">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <h3>Informações do Evento</h3>
                            <div class="mb-3">
                                <label>Nome</label>
                                <input type="text" wire:model.debounce.500ms="app.event.name" class="form-control">
                                @error('app.event.name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Descrição</label>
                                <input type="text" wire:model.debounce.500ms="app.event.description" class="form-control">
                                @error('app.event.description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Inicio</label>
                                    <input type="datetime-local" wire:model.debounce.500ms="app.event.start_time"
                                           class="form-control" id="start_time">
                                    @error('app.event.start_time') <span
                                        class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Fim</label>
                                    <input type="datetime-local" wire:model.debounce.500ms="app.event.end_time"
                                           class="form-control" id="end_time">
                                    @error('app.event.end_time') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Endereço</h3>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>CEP</label>
                                    <input type="text" wire:model.debounce.500ms="app.address.zipcode" class="form-control"
                                           wire:change="getCep">
                                    @error('app.address.zipcode') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Bairro</label>
                                    <input type="text" wire:model.debounce.500ms="app.address.district"
                                           id="district"
                                           class="form-control">
                                    @error('app.address.district') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label>Endereço</label>
                                    <input type="text" wire:model.debounce.500ms="app.address.street" class="form-control"
                                           id="street">
                                    @error('app.address.street') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label>Número</label>
                                    <input type="text" wire:model.debounce.500ms="app.address.number" class="form-control">
                                    @error('app.address.number') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Complemento</label>
                                    <input type="text" wire:model.debounce.500ms="app.address.complement"
                                           class="form-control" id="complement">
                                    @error('app.address.complement') <span
                                        class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Cidade</label>
                                    <input type="text" wire:model.debounce.500ms="app.address.city" class="form-control"
                                           id="city">
                                    @error('app.address.city') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Estado</label>
                                    <input type="text" wire:model.debounce.500ms="app.address.state" class="form-control"
                                           id="state">
                                    @error('app.address.state') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>


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
