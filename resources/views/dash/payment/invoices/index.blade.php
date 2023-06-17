<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-barcode"></i>
                        </div>
                        Pagamentos: Faturas
                    </h1>
                </div>

                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{route('dash.payment.index')}}">
                        <i class="fad fa-file-invoice-dollar fa-lg me-1"></i>
                        Listar Planos
                    </a>
                    <a class="btn btn-sm btn-light text-primary"
                       href="{{route('dash.payment.planSelected')}}">
                        <i class="fad fa-shopping-cart fa-lg me-1"></i>
                        Ver Plano Atual
                    </a>
                    <a class="btn btn-sm btn-light text-primary" href="{{route('dash.payment.allInvoices')}}">
                        <i class="fad fa-receipt fa-lg me-1"></i>
                        Ver Faturas
                    </a>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Status</th>
                <th scope="col">Quantia paga</th>
                <th scope="col">Total</th>
                <th scope="col">Início do Período</th>
                <th scope="col">Livemode</th>
            </tr>
            </thead>
            <tbody>

            @forelse($invoices as $invoices)
                <tr>
                    <td class="d-none">{{$invoices->id}}</td>
                    <td>{{$invoices->number}}</td>
                    <td>{{$invoices->status}}</td>
                    <td>{{formatCurrency($invoices->amount_paid/100,$invoices->currency)}}</td>
                    <td>{{formatCurrency($invoices->total/100,$invoices->currency)}}</td>
                    <td>{{\Illuminate\Support\Carbon::parse($invoices->period_start)->translatedFormat('D, d M Y H:i:s')}}</td>
                    {{--        <td>{{\Illuminate\Support\Carbon::parse($invoices->period_end)->translatedFormat('D, d M Y H:i:s')}}</td>--}}
                    <td>{{$invoices->livemode?'Ativo':'Test'}}</td>


                </tr>
            @empty
                <p>Sem Faturas</p>
            @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>
