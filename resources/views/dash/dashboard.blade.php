<x-app-layout>
    <x-slot name="header">
        <div class="col-auto mt-4">
            <h1 class="page-header-title">
                <div class="page-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-file">
                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                        <polyline points="13 2 13 9 20 9"></polyline>
                    </svg>
                </div>
                {{ __('Dashboard') }}
            </h1>
            <div class="page-header-subtitle">A simplified page header for use with the dashboard layout</div>
        </div>
    </x-slot>



    {{--    <x-jet-welcome />--}}
</x-app-layout>
