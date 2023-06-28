<x-app-layout>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Avisos</h3>
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                                @foreach($alerts as $alert)
                                    <li>
                                        <a href="{{$alert->data['url']}}"
                                           class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'>
                                            <input type="hidden" name="notification" id="notification_id">
                                            <div class="peer mR-15">
                                                @if(is_null($alert->read_at))
                                                    <i class="fal fa-envelope fa-2x"></i>
                                                @else
                                                    <i class="fal fa-envelope-open fa-2x"></i>
                                                @endif
                                            </div>
                                            <div class="peer mR-15">
                                                <span>Por: System</span>
                                            </div>
                                            <span class="peer peer-greed">{{$alert->data['type']}}<span>
                                            <span class="fw-500">{{$alert->data['text']}}</span>
{{--                                            <span class="c-grey-600">{!! $alert->data['body'] !!}--}}
                                            </span>
                                                </span>
                                            <p class="m-0">
                                                <small
                                                    class="fsz-xs">{{\Illuminate\Support\Carbon::parse($alert['created_at'])?->format('d/m/Y H:i')}}</small>
                                            </p>
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
