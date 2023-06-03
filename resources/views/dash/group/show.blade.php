<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Group') }}
        </h2>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {{$group}}
    </div>
</x-app-layout>
