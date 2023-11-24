<li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts"
       href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
       aria-expanded="false">
        <i class="fa fa-bell"></i>
        @if(count($notifications) > 0)
            <span class="badge bg-danger badge-notifications">
                    {{count($notifications)}}
            </span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
         wire:poll.visible.15s
         aria-labelledby="navbarDropdownAlerts"
    >
        <h6 class="dropdown-header dropdown-notifications-header">
            <i class="me-2 fa fa-bell"></i>
            Alerts Center
        </h6>
        @foreach($notifications?->take(3) as $alert)
            <a class="dropdown-item dropdown-notifications-item" href="{{$alert->data['url']??'#'}}"
               wire:click="markAsRead('{{$alert->id}}')"
            >
                <div class="dropdown-notifications-item-icon bg-{{$alert->data['type']}}">
                    <i class="fa fa-warning"></i>
                </div>
                <div class="dropdown-notifications-item-content">
                    <div
                        class="dropdown-notifications-item-content-details">
                        {{\Illuminate\Support\Carbon::parse($alert->data['date'])->shortRelativeToNowDiffForHumans()}}
                    </div>
                    <div
                        class="dropdown-notifications-item-content-text">
                        {{strlen($alert->data['text'])>40?\Illuminate\Support\Str::substr($alert->data['text'], 0, 40).'...':$alert->data['text']}}
                    </div>
                </div>
            </a>
        @endforeach
{{--        @if(count($notifications) > 0)--}}
            <a class="dropdown-item dropdown-notifications-footer" href="{{route('user.alert')}}">View All Alerts</a>
{{--        @endif--}}
    </div>
</li>

