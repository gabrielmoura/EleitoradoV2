<x-guest-layout>
    <div class="bg-gradient-primary-to-secondary vh-100">
        <div class="container-xl px-4">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header justify-content-center">
                            <div class="card-body p-5 text-center">
                                <div class="icons-org-join align-items-center mx-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user icon-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <svg class="svg-inline--fa fa-right-long icon-arrow" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="right-long" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M504.3 273.6l-112.1 104c-6.992 6.484-17.18 8.218-25.94 4.406c-8.758-3.812-14.42-12.45-14.42-21.1L351.9 288H32C14.33 288 .0002 273.7 .0002 255.1S14.33 224 32 224h319.9l0-72c0-9.547 5.66-18.19 14.42-22c8.754-3.809 18.95-2.075 25.94 4.41l112.1 104C514.6 247.9 514.6 264.1 504.3 273.6z">

                                        </path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-users icon-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <div class="h3 text-secondary mb-0">Junte-se a organização</div>
                            </div>
                            @if ($errors->any())
                                <div {{ $attributes??null }}>
                                    <div
                                        class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-body">

                            <!-- Registration form-->
                            <form class="user" method="POST" action="{{ route('auth.invite.store') }}">
                                @csrf
                                <!-- Form Row-->
                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <!-- Form Group (first name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputFirstName">Nome</label>
                                            <input class="form-control" id="inputFirstName" type="text"
                                                   placeholder="Seu nome"
                                                   value="{{ old('name') }}" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Form Group (last name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputLastName">Telefone</label>
                                            <input class="form-control cel" id="inputLastName" type="text"
                                                   placeholder="Seu celular"
                                                   value="{{ old('phone') }}" name="phone">
                                        </div>
                                    </div>
                                </div>
                                <!-- Form Group (email address)            -->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                                    <input class="form-control" id="inputEmailAddress" type="email"
                                           aria-describedby="emailHelp" placeholder="Seu email"
                                           value="{{session('email')}}" disabled>
                                </div>
                                <!-- Form Row    -->
                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <!-- Form Group (password)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input class="form-control" id="inputPassword" type="password"
                                                   placeholder="Sua senha"
                                                   value="{{ old('password') }}" name="password"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Form Group (confirm password)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputConfirmPassword">Confirm
                                                Password</label>
                                            <input class="form-control" id="inputConfirmPassword" type="password"
                                                   placeholder="Confirm password"
                                                   value="{{ old('password_confirmation') }}"
                                                   name="password_confirmation"
                                            >
                                        </div>
                                    </div>
                                </div>
                                <!-- Form Group (create account submit)-->
                                <button type="submit" class="btn btn-secondary btn-block">Criar Conta</button>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <div class="small">
                                <a href="{{route('login')}}">Tem uma conta? Ir para login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
