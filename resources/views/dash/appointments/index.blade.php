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
    <div class="container">
        <div id="calendar"></div>
    </div>
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Criar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    ></button>
                </div>
                <form method="POST" action="{{route('dash.appointment.store')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <h3>Informações do Evento</h3>
                                <div class="mb-3">
                                    <label>Nome</label>
                                    <input type="text" name="name" class="form-control">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Descrição</label>
                                    <input type="text" name="description" class="form-control">
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Inicio</label>
                                        <input type="datetime-local" name="start_time"
                                               class="form-control" id="start_time">
                                        @error('start_time') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Fim</label>
                                        <input type="datetime-local" name="end_time"
                                               class="form-control" id="end_time">
                                        @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h3>Endereço</h3>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>CEP</label>
                                        <input type="text" name="zipcode" class="form-control"
                                               wire:change="getCep">
                                        @error('zipcode') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Bairro</label>
                                        <input type="text" name="district"
                                               id="district"
                                               class="form-control">
                                        @error('district') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="mb-3">
                                        <label>Endereço</label>
                                        <input type="text" name="street" class="form-control"
                                               id="street">
                                        @error('street') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Número</label>
                                        <input type="text" name="number" class="form-control">
                                        @error('number') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Complemento</label>
                                        <input type="text" name="complement"
                                               class="form-control" id="complement">
                                        @error('complement') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Cidade</label>
                                        <input type="text" name="city" class="form-control"
                                               id="city">
                                        @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Estado</label>
                                        <input type="text" name="state" class="form-control"
                                               id="state">
                                        @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Fechar
                        </button>
                        <button type="submit" class="btn btn-primary">Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    themeSystem: 'bootstrap',
                    firstDay: 0,
                    initialView: 'timeGridWeek',
                    slotMinTime: '8:00:00',
                    slotMaxTime: '19:00:00',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    buttonText: {
                        today: 'Hoje',
                        month: 'Mês',
                        week: 'Semana',
                        day: 'Dia',
                        list: 'Lista',
                    },
                    locale: 'pt-br',
                    navLinks: true, // can click day/week names to navigate views
                    selectable: false, // permite selecionar um dia/hora
                    eventDidMount: function (info) {
                        var tooltip = new bootstrap.Tooltip(info.el, {
                            title: info.event.extendedProps.description,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                        if (info.event.extendedProps?.status === 'done') {
                            info.el.style.backgroundColor = 'red';
                            var dotEl = info.el.getElementsByClassName('fc-event-dot')[0];
                            if (dotEl) {
                                dotEl.style.backgroundColor = 'white';
                            }
                        }
                    },
                    dateClick: function (info) {
                        var myModal = new bootstrap.Modal(document.getElementById('createModal'))
                        myModal.show()
                        document.getElementById('start_time').value = info.date.toISOString().slice(0, 16);
                        {{--window.location.href = '{{route('dash.appointment.create')}}?start_date=' + info.date.toISOString().slice(0,16);--}}
                    },
                    events: function (info, successCallback, failureCallback) {
                        axios.get('{{route('dash.appointment.index')}}', {
                            params: {
                                start: info.startStr,
                                end: info.endStr,
                            }
                        })
                            .then(function (response) {
                                successCallback(response.data);
                            })
                            .catch(function (error) {
                                flasher.error('Houve um erro ao buscar eventos!');
                                failureCallback(error);
                            });
                    }
                });
                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
