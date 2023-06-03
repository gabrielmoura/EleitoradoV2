<div id="layoutSidenav_content">
    <h2>Criar Grupo</h2>
    <form wire:submit.prevent="store">
        <div class="form-group">
            <label for="name">Nome</label>
            <input wire:model.debounce.500ms="name" type="text" class="form-control" id="name"
                   placeholder="Nome do Grupo">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="description">Descrição</label>
            <textarea wire:model.debounce.500ms="description" class="form-control" id="description" rows="3"></textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary"
                wire:target="store"
                wire:loading.attr="disabled"
                :disabled="$disabled"
        >Criar
        </button>
    </form>
</div>
