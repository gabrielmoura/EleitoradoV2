<x-guest-layout>
    <div class="bg-gradient-primary-to-secondary vh-100">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Bem-vindo</h1>
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
                                        <form class="user" method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user"
                                                       id="exampleInputEmail" aria-describedby="emailHelp"
                                                       name="email" value="{{ request('email')??old('email') }}"
                                                       placeholder="Enter Email Address" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                       id="exampleInputPassword" placeholder="Password"
                                                       autocomplete="current-password" name="password"
                                                >
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck"
                                                           name="remember">
                                                    <label class="custom-control-label" for="customCheck">Lembrar</label>
                                                </div>
                                            </div>

                                           <div class="text-center">
                                               <button type="submit" class="btn btn-primary btn-user btn-block">
                                                   {{ __('Log in') }}
                                               </button>
                                               <hr>
                                               <a href="index.html" class="btn btn-google btn-user btn-block">
                                                   <i class="fab fa-google fa-fw"></i> Entrar com o Google
                                               </a>
                                               <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                                   <i class="fab fa-facebook-f fa-fw"></i> Entrar com o Facebook
                                               </a>
                                           </div>

                                        </form>
                                        <hr>
                                        @if (Route::has('password.request'))
                                            <div class="text-center">
                                                <a class="small" href="{{ route('password.request') }}">Esqueceu a Senha?</a>
                                            </div>
                                        @endif
                                        @if(\Laravel\Fortify\Features::enabled(\Laravel\Fortify\Features::registration()))
                                            <div class="text-center">
                                                <a class="small" href="{{route('register')}}">Criar uma conta!</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
