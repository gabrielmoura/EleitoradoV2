<div class="d-flex align-items-center" wire:click="orderBy('{{$name}}')" wire:change="orderBy"
     wire:change="orderAsc" style="cursor:pointer;">
    <span>{{$title}}
        @if($defaultReorderColumn == $name)
            @if($defaultReorderASC)
                <i class="fad fa-sort-amount-down"></i>
            @else
                <i class="fad fa-sort-amount-up"></i>
            @endif
        @else
            <i class="fad fa-sort-alt"></i>
        @endif
    </span>
</div>
