<x-app-layout>
    <x-slot name="header">
        <x-header-simplified>
            <x-slot:content>
                <h1 class="page-header-title">
                    <div class="page-header-icon">
                        <i class="fad fa-home fa-lg"></i>
                    </div>
                    Bem vindo a {{config('app.name')}}
                </h1>
{{--                <div class="page-header-subtitle">123</div>--}}
            </x-slot:content>
        </x-header-simplified>
    </x-slot>
    <div class="container">
        <div class="row m-1">
            <div class="col-md-3">
                <div class="card">
                    <div class="cad-body">
                        {!! $personChart->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="cad-body">
                        {!! $demandChart->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="cad-body">
                        {!! $demandChartType->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="cad-body">
                        {!! $personSexChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    {!! $personChart->script() !!}
    {!! $demandChart->script() !!}
    {!! $demandChartType->script() !!}
    {!! $personSexChart->script() !!}
</x-app-layout>
