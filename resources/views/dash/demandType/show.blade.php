<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="me-1 far fa-calendar-alt"></i>
                        </div>
                        Tipo de Demanda: {{$demandType->name}}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{route('dash.demandType.index')}}">
                        <i class="me-1 far fa-calendar-alt"></i>
                        Listar Tipo de Demandas
                    </a>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="card">
            <div class="card-header">
                {{$demandType->name}}
            </div>
            <div class="card-body">
                <dl>
                    <dd>Responsável: {{$demandType->responsible}}</dd>
                    <dd>Descrição: {{$demandType->description}}</dd>
                </dl>

            </div>
        </div>
    </div>
</x-app-layout>
