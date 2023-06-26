<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <h2 class="h4 font-weight-bold">
                    {{ __('Eleitores') }}: Alterações
                </h2>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="row">
        <div class="bgc-white bd bdrs-3 p-20 mB-20 col">
            <button onclick="printData('history')">
                <i class="fa fa-print"></i>
            </button>
            <table class="table table-striped table-bordered display nowrap" cellspacing="0" id="history">
                <thead>
                <tr>
                    <th>Alterado Em</th>
                    <th>Status</th>
                    <th>Por</th>
                    <th>Ateração</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Alterado Em</th>
                    <th>Status</th>
                    <th>Por</th>
                    <th>Ateração</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($person->activities as $history)
                    <tr>
                        <td>{{$history->created_at->format('d/m/Y H:i')}}
                            {{$history->created_at->diffForHumans()}}</td>
                        <td>{{\App\Service\Enum\HistoryOptions::getStatusOption($history->event)}}</td>
                        <td>{{$history->causer->name}}</td>
                        <td>
                            <ul>
                                @foreach($history?->properties as $key=>$item)
                                    <li>{{__($key)}}
                                        <ul>
                                            @foreach($item as $key=>$value)
                                                <li>
                                                    <span class="h5 ml-3">{{$key}}</span>
                                                    <span>{{$value}}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if(isset($voter->checkIns))
            <div class="bgc-white bd bdrs-3 p-20 mB-20 col">
                <h3>Checkin</h3>
                <table class="table table-striped table-bordered display nowrap" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Por</th>
                        <th>Descrição</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($voter->checkIns as $checkIn)
                        <tr>
                            <td>{{$checkIn->created_at->format('d/m/Y H:i')}}
                                {{$checkIn->created_at->diffForHumans()}}</td>
                            <td>{{$checkIn->user->name}}</td>
                            <td>{{$checkIn->description}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        @endif
    </div>
</x-app-layout>
