<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-money-check-edit fa-lg"></i>
                        </div>
                        Plano : {{$plan->get('plan')->name}}
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="container">
        <code>
            {{$plan->get('plan')}}
        </code>
        <br><br><br>
        <code>
            {{$plan->get('gw')}}
        </code>


    </div>
</x-app-layout>
