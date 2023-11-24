<x-app-layout>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Avisos</h3>
        @if($alerts->count() > 0 )
            <btn class="btn btn-primary" onclick="Livewire.emit('markAllAsRead')">Marcar todos como lidos</btn>
        @endif
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="d-block">
                        @foreach($alerts as $alert)
                            <div class="card m-3">
                                <div class="card-title">
                                </div>
                                <div class="card-body">
                                    <div
                                        class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'>
                                        <input type="hidden" name="notification" id="notification_id"
                                               value="{{$alert->data['uid']}}">

                                        <div class="peer mR-15">
                                            @if(is_null($alert->read_at))
                                                <i class="fal fa-envelope fa-2x"></i>
                                            @else
                                                <i class="fa-solid fa-envelope-open fa-2x"></i>
                                            @endif
                                            @if($alert->data['type']=='info')
                                                <i class="fas fa-info-circle"></i>
                                            @endif
                                            @if($alert->data['type']=='warning')
                                                <i class="fas fa-exclamation-triangle"></i>
                                            @endif
                                            @if($alert->data['type']=='danger')
                                                <i class="fas fa-exclamation-circle"></i>
                                            @endif
                                            @if($alert->data['type']=='success')
                                                <i class="fas fa-check-circle"></i>
                                            @endif
                                            <a class="btn btn-primary btn-sm" href="{{$alert->data['url']}}">
                                                Abrir
                                            </a>
                                        </div>
                                        <div class="peer mR-15">
                                            <span>Por: System</span>
                                        </div>
                                        <span class="fw-500">Mensagem: {{$alert->data['text']}}</span>

                                        <p class="m-0">
                                            <small
                                                class="fsz-xs">{{\Illuminate\Support\Carbon::parse($alert['created_at'])?->format('d/m/Y H:i')}}
                                            </small>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
