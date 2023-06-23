<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="me-1 fad fa-calendar"></i>
                        </div>
                        Agendamentos
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <livewire:appointment.appointment-list />
    <livewire:appointment.appointment-create />
</x-app-layout>
