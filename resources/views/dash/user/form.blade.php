<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-user-shield fa-lg"></i>
                        </div>
                        Usuários
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <form action="{{$form['action']}}" method="POST">
        @method($form['method'])
        @csrf
        <fieldset>
            <legend>Dados do Usuário</legend>
            <div class="row">
                <div class="from-group mb-3  col-md-6">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                           placeholder=""
                           value="{{$user->name??old('name')}}">
                    @if($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                </div>
                <div class="from-group mb-3  col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email"
                           class="form-control date-time @error('email') is-invalid @enderror" id="email"
                           placeholder=""
                           value="{{$user->email??old('email')}}">
                    @if($errors->has('email'))
                        <em class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </em>
                    @endif
                </div>

                <div class="form-group mb-3 col-md-6">
                    <label for="role" class="form-label">Função *</label>
                    <select class="select form-control tselect @error('role') is-invalid @enderror" name="role"
                            id="role">
                        @foreach($roles as $key)
                            <option value="{{$key->name}}"
                                {{--(isset($event)&&$user->recurrence==$key)?'selected':null--}}>{{\App\Service\Enum\RoleOptions::getRoleOption($key->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-6">
                    <label for="password" class="form-label">Senha</label>
                    <input type="text"
                           class="form-control" id="password"
                           placeholder="A senha será definida automaticamente"
                           disabled>
                </div>
            </div>
        </fieldset>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</x-app-layout>
