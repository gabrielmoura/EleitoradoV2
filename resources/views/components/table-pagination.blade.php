<div class="d-md-flex justify-content-between">
    @if($items->total()>$perPage)
        Mostrando {{$items->firstItem()}} a {{$items->lastItem()}} de {{$items->total()}} resultados
    @else
        Mostrando {{$items->total()}} resultados
    @endif
    {{ $items->links() }}
</div>
