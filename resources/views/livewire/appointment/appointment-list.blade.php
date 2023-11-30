<div class="container">
    <div id="calendar"></div>
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
                        new bootstrap.Tooltip(info.el, {
                            title: info.event.extendedProps?.description ?? '',
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
                        Livewire.emit('startTimeChanged', info.date.toISOString().slice(0, 16));
                        {{--window.location.href = '{{route('dash.appointment.create')}}?start_date=' + info.date.toISOString().slice(0,16);--}}
                    },
                    events: function (info, successCallback, failureCallback) {
                        axios.get('{{route('dash.appointment.ajax')}}', {
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
</div>

