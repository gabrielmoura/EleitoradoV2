<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-industry-alt fa-lg"></i>
                        </div>
                        Empresas
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <form action="{{route('admin.company.store')}}" class="form">

        </form>
    </div>
</x-app-layout>
