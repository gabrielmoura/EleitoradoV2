<div>
    <h2>Configurações</h2>
    @foreach($company->config()->all(true) as $key=>$value)
        <div class="form-group">
            <label for="{{$key}}">{{$key}}</label>
            @if(is_bool($value))
                <input type="checkbox" id="{{$key}}" wire:model="config.{{$key}}"
                       class="form-check-input">
            @else
                <input type="text" id="{{$key}}" wire:model="config.{{$key}}"
                       {{is_bool($value)?'checked':''}}
                       class="form-control">
            @endif
        </div>
    @endforeach
    <button type="button" class="btn btn-primary " wire:click="store">Salvar Configuração</button>
</div>
