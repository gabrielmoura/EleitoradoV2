<x-guest-layout>
    <div class="bg-gradient-primary-to-secondary vh-100">
        <div class="container-xl px-4">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header justify-content-center">
                            <div class="card-body p-5 text-center">
                                <div class="h3 text-secondary mb-0">Recuperação de conta</div>
                            </div>
                            @if ($errors->any())
                                <div {{ $attributes??null }}>
                                    <div
                                        class="font-medium text-red">{{ __('Whoops! Something went wrong.') }}</div>

                                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <p>
                                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                            </p>
                            <!-- Registration form-->
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                                    <input class="form-control" id="inputEmailAddress" type="email"
                                           aria-describedby="emailHelp" placeholder="Seu email"
                                           name="email"
                                           value="{{session('email')??old('email')}}" required autofocus
                                           autocomplete="username">
                                </div>

                                <button type="submit" class="btn btn-secondary btn-block">Enviar</button>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <div class="small">
                                <a href="{{route('login')}}">Ir para login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

