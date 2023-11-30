<li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages"
       href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
       aria-expanded="false"><i data-feather="mail"></i></a>
    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
         aria-labelledby="navbarDropdownMessages">
        <h6 class="dropdown-header dropdown-notifications-header">
            <i class="me-2" data-feather="mail"></i>
            {{__('Message Center')}}
        </h6>

        @foreach($messages as $message)
            <a class="dropdown-item dropdown-notifications-item" href="#!">
                <img alt="{{$message['name']}}" class="dropdown-notifications-item-img" src="{{$message['img']}}"/>
                <div class="dropdown-notifications-item-content">
                    <div class="dropdown-notifications-item-content-text">
                        {{$message['text']}}
                    </div>
                    <div class="dropdown-notifications-item-content-details">
                        {{$message['name']}}· {{$message['time']}}
                    </div>
                </div>
            </a>
        @endforeach
        @if(count($messages)>0)
            <a class="dropdown-item dropdown-notifications-footer" href="#!">{{__('Read All Messages')}}</a>
        @endif
    </div>
</li>
