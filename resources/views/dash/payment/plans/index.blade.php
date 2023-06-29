<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-barcode"></i>
                        </div>
                        Pagamentos: Planos
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

    <div class="pricing-columns">
        <div class="row justify-content-center">
            @forelse($plans as $plan)
                <div class="col-xl-4 col-lg-6 mb-4 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-header bg-transparent">
                            <span
                                class="badge bg-primary-soft text-primary rounded-pill py-2 px-3 mb-2">{{ strtoupper($plan->name) }}</span>
                            {{session('subscribed.stripe_price') == $plan->name? 'Plano Atual' : ''}}
                            <div class="pricing-columns-price">
                                {{formatCurrency($plan->price/100,$plan->currency)}}
                                <span>/{{$plan->billing_period}}</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($plan->features as $feature)
                                    <li class="list-group-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round"
                                             class="feather feather-check-circle text-primary me-2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        {{$feature}}
                                    </li>
                                @empty
                                    <li class="list-group-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round"
                                             class="feather feather-check-circle text-primary me-2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        Funcionalidades não cadastradas.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        <a class="card-footer d-flex align-items-center justify-content-between"
                           href="{{route('dash.payment.show',$plan->slug)}}">
                            {{session('subscribed.stripe_price') == $plan->name? 'Ver Plano' : 'Contratar'}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-arrow-right">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col mb-4 mb-xl-0">
                    <h1> Nenhum Plano Cadastrado</h1>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
