<div wire:ignore.self class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="{{$modalId}}Label"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Remover Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
            </div>
            <form wire:submit.prevent="delete">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <h3>Informações do Evento</h3>
                            <div class="mb-3">
                                Tem certeza que deseja remover o evento <strong>{{$appointment->name}}</strong>?
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
                            :disabled="$disabled">Remover
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
