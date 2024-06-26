<x-app-layout>

    <form method="POST" action="{{ route('dash.appointment.store') }}">
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <h3>Informações do Evento</h3>
                    <div class="mb-3">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" class="form-control">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description">Descrição</label>
                        <input type="text" wire:model.debounce.500ms="description" id="description"
                               class="form-control">
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date">Inicio</label>
                            <input type="datetime-local" name="start_date"
                                   class="form-control" id="start_date"
                                   value="{{old('start_date',request('start_date'))}}">
                            @error('start_date') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end_date">Fim</label>
                            <input type="datetime-local" wire:model.debounce.500ms="end_date"
                                   id="end_date" class="form-control">
                            @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3>Endereço</h3>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="zipcode">CEP</label>
                            <input type="text" wire:model.debounce.500ms="zipcode" class="form-control"
                                   id="zipcode" wire:change="getCep">
                            @error('zipcode') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="district">Bairro</label>
                            <input type="text" wire:model.debounce.500ms="district"
                                   id="district"
                                   class="form-control">
                            @error('district') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="street">Endereço</label>
                            <input type="text" wire:model.debounce.500ms="street" class="form-control"
                                   id="street">
                            @error('street') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="number">Número</label>
                            <input type="text" wire:model.debounce.500ms="number" class="form-control" id="number">
                            @error('number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="complement">Complemento</label>
                            <input type="text" wire:model.debounce.500ms="complement"
                                   class="form-control" id="complement">
                            @error('complement') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="city">Cidade</label>
                            <input type="text" wire:model.debounce.500ms="city" class="form-control"
                                   id="city">
                            @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="state">Estado</label>
                            <input type="text" wire:model.debounce.500ms="state" class="form-control"
                                   id="state">
                            @error('state') <span class="text-danger">{{ $message }}</span> @enderror
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

</x-app-layout>
