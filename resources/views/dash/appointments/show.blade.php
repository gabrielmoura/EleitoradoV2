<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="me-1 fad fa-calendar fa-lg"></i>
                        </div>
                        Agendamento: {{$appointment?->name}}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#appointment-modal-delete">
                        <i class="me-1 fad fa-trash"></i>
                        Apagar
                    </button>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#appointment-modal-edit">
                        <i class="me-1 fad fa-edit"></i>
                        Editar
                    </button>
                    <a class="btn btn-sm btn-light text-primary" href="{{$appointment->link()->google()}}"
                       target="_blank">
                        <i class="me-1 fad fa-calendar"></i>
                        Google Agenda
                    </a>
                    <a class="btn btn-sm btn-light text-primary" href="{{$appointment->link()->ics()}}" target="_blank">
                        <i class="me-1 fad fa-calendar"></i>
                        ICS
                    </a>
                    <a class="btn btn-sm btn-light text-primary" href="{{$appointment->link()->WebOffice()}}"
                       target="_blank">
                        <i class="me-1 fad fa-calendar"></i>
                        MS Office
                    </a>
                    <a class="btn btn-sm btn-light text-primary" href="{{$appointment->link()->yahoo()}}"
                       target="_blank">
                        <i class="me-1 fad fa-calendar"></i>
                        Yahoo
                    </a>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="card">
            <div class="card-header">
                <h3 class="text-start text-xl">{{$appointment->name}}</h3>
            </div>
            <div class="card-body m-3">
                <div class="row">
                    <div class="col-md-4">
                        <img width="250px" height="250px" class="avatar-img img-thumbnail" alt="{{$appointment->name}}"
                             src="{{$appointment?->profile_photo_url??'/build/assets/calendario-g-0dd9036b.webp'}}">
                    </div>
                    <div class="col-md-8">
                        <h2>Dados Pessoais</h2>

                        Nome: {{$appointment->name}}<br>
                        @if($appointment->banned_at!= null)
                            <span class="badge bg-danger">BAN</span>
                        @endif
                        <br>
                        Descrição: {{$appointment->description}}<br>
                        Inicio: {{$appointment->start_time->format('d/m/y H:i')}}<br>
                        Fim: {{$appointment->end_time?->format('d/m/y H:i')}}<br>
                        Endereço: {{$appointment?->address?->full_address}}<br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:appointment.appointment-modal-edit :appointment="$appointment"/>
    <livewire:appointment.appointment-modal-delete :appointment="$appointment"/>
</x-app-layout>
