<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Tags') }}
        </h2>
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
                    <td>{{__($history->event)}}</td>
                    <td>{{($history->causer_type=='App\Models\User')? $history->causer()->first()->name:null}}</td>
                    <td>
                        <ul>
                            @foreach($history?->properties as $name=>$item)
                                <li>{{__($name)}}
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
