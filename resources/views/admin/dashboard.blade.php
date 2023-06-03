<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-media-library-attachment name="media" />
    <x-media-library-collection
        name="images"
        :model="$user"
        collection="images"
        max-items="3"
{{--        rules="mimes:png,jpeg"--}}

    />
    <x-jet-welcome />
</x-app-layout>
