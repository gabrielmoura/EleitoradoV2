<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Eleitores') }}
        </h2>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {{$person}}
    </div>
</x-app-layout>
