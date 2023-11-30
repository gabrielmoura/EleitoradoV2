<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <h2 class="h4 font-weight-bold">
                    Tipo de Demanda
                </h2>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered display nowrap" cellspacing="0">
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
            @foreach($histories as $history)
                <tr>
                    <td>{{$history->created_at}}</td>
                    <td>{{\App\Service\Enum\HistoryOptions::getStatusOption($history->event)}}</td>
                    <td>{{($history->causer_type=='App\Models\Group')? $history->causer()->first()->name:null}}</td>
                    <td>
                        <ul>
                            @foreach($history?->properties as $key=>$item)
                                <li>{{\App\Service\Enum\HistoryOptions::getAttributeOption($key)}}
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
</x-app-layout>
