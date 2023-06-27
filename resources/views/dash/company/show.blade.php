<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-industry-alt fa-lg"></i>
                        </div>
                        Empresa: {{$company->name}}
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="card">
            <div class="card-header">
                <h3 class="text-start text-xl">{{$company->name}}</h3>
            </div>
            <div class="card-body m-3">
                <div class="row">
                    <div class="col-md-4">
                        <img width="250px" height="250px" class="avatar-img img-thumbnail" alt="{{$company->name}}"
                             src="{{$company->logo??\Illuminate\Support\Facades\Vite::asset('resources/images/company-logo.png')}}">
                    </div>
                    <div class="col-md-4">
                        <h2>Dados</h2>
                        Nome: {{$company->name}}<br>

                        <br>
                        Email: {{$company->email}}<br>
                        Data de Cadastro: {{$company->created_at->format('d/m/y H:i')}}<br>
                        Data de Atualização: {{$company->updated_at->format('d/m/y H:i')}}<br>
                        Endereço: {{$company->address}}<br>
                        @foreach($company->tax_id_data??[] as $key => $value)
                            {{$key}}: {{$value}}<br>
                        @endforeach
                    </div>
{{--                    <div class="col-md-4">--}}
{{--                        <livewire:company-config :company="$company"/>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
