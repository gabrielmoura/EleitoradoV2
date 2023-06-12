<x-guest-layout>
    <div class="bg-gradient-primary-to-secondary vh-100">
        <div class="container-xl px-4">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header justify-content-center">
                            <div class="card-body p-5 text-center">
                                <div class="h3 text-secondary mb-0">Redefinir Senha</div>
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
                            <!-- Registration form-->
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                                    <input class="form-control" id="inputEmailAddress" type="email"
                                           aria-describedby="emailHelp" placeholder="Seu email"
                                           name="email"
                                           value="{{old('email',$request->email)}}" required autofocus
                                           autocomplete="username">
                                </div>


                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <!-- Form Group (first name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="password">Senha</label>
                                            <input class="form-control" id="password" type="password"
                                                   placeholder="Senha" required autocomplete="new-password"
                                                   name="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Form Group (last name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="password_confirmation">Confirmação de
                                                Senha</label>
                                            <input class="form-control" id="password_confirmation" type="password"
                                                   placeholder="Confirmação de Senha" required
                                                   autocomplete="new-password"
                                                   name="password_confirmation">
                                        </div>
                                    </div>
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

