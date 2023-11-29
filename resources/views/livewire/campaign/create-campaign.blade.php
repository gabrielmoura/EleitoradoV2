<div class="card">
    <div class="card-header">
        Criar Campanha
    </div>
    <div class="card-body">
        <form wire:submit.prevent="save">
            <div>
                <label for="title">Título</label>
                <input class="form-control" wire:model.debounce.500ms="data.title" id="title" type="text" label="Título"
                       required>
                @error('data.title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="description">Descrição</label>
                <input class="form-control" wire:model.debounce.500ms="data.description" id="description" type="text"
                       label="Descrição">
                @error('data.description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="message">Mensagem</label>
                <textarea class="form-control" wire:model.debounce.500ms="data.message" id="message" type="text"
                          label="Mensagem" required></textarea>
                @error('data.message') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="url">URL</label>
                <input class="form-control" wire:model.debounce.500ms="data.url" id="url" type="text" label="URL">
                @error('data.url') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="to_type">Tipo do Destino</label>
                <select class="form-control" wire:model.debounce.500ms="data.to_type" id="to_type">
                    <option value="">Selecione</option>
                    @foreach($toTypes as $name=>$value)
                        <option value="{{$value}}">{{$name}}</option>
                    @endforeach
                </select>
                @error('data.to_type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="to_id">Destino ID</label>
                <input class="form-control" wire:model.debounce.500ms="data.to_id" id="to_id" type="number"
                       label="Destino" required/>
                @error('data.to_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="channel">Canal</label>
                <select class="form-control" wire:model.debounce.500ms="data.channel" id="channel">
                    <option value="">Selecione</option>
                    @foreach($channels as $name=>$value)
                        <option value="{{$value}}">{{$name}}</option>
                    @endforeach
                </select>
                @error('data.channel') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-media-library-attachment name="data.file" max-items="1"
                                            editableName/>
            </div>

            <button type="submit" class="btn btn-primary"
                    wire:target="save"
                    wire:loading.attr="disabled"
                    :disabled="$disabled">Salvar
            </button>
        </form>
    </div>
</div>
