<x-app-layout>
    <x-slot name="header">
        <x-header-simplified>
            <x-slot:content>
                <h1 class="page-header-title">
                    <div class="page-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-file">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                    </div>
                    Bem vindo a {{config('app.name')}}
                </h1>
                <div class="page-header-subtitle">123</div>
            </x-slot:content>
        </x-header-simplified>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                Contagem por Mês
                {!! $personChart->container() !!}

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $personChart->script() !!}
</x-app-layout>
