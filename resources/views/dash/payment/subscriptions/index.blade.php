<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-barcode"></i>
                        </div>
                        Pagamentos: Plano Atual
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
    <style>
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('alert-success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('alert-success') }}
                            </div>
                        @endif

                        @if (count($subscriptions) > 0)
                            <h4><b>Your Subscriptions</b></h4>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Plan Name</th>
                                    <th scope="col">Subs Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Trial Start At</th>
                                    <th>Auto Renew</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $subscription->stripe_price }}</td>
                                        <td>{{ $subscription->name }}</td>
                                        <td>{{ $subscription->plan?->price }}</td>
                                        <td>{{ $subscription->quantity }}</td>
                                        <td>{{ $subscription->created_at }}</td>
                                        <td>
                                            <label class="switch">
                                                @if ($subscription->ends_at == null)
                                                    <input type="checkbox" id="switcher" checked
                                                           value="{{ $subscription->name }}">
                                                @else
                                                    <input type="checkbox" id="switcher"
                                                           value="{{ $subscription->name }}">
                                                @endif

                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4>Você não está inscrito em nenhum plano</h4>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#switcher').click(function () {
                var subscriptionName = $('#switcher').val();
                if ($(this).is(':checked')) {
                    axios.post('{{ route("dash.payment.resume") }}', {subscriptionName}).then((response) => {
                        console.log(response);
                    });
                } else {

                    axios.post('{{ route("dash.payment.cancel") }}', {subscriptionName}).then((response) => {
                        console.log(response);
                    });
                }
            });
        });
    </script>
</x-app-layout>
