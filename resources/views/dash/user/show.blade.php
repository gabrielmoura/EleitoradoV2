<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-user-shield fa-lg"></i>
                        </div>
                        Usuário: {{$user->name}}
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="card">
            <div class="card-header">
                <h3 class="text-start text-xl">{{$user->name}}</h3>
            </div>
            <div class="card-body m-3">
                <div class="row">
                    <div class="col-md-4">
                        <img width="250px" height="250px" class="avatar-img img-thumbnail" alt="{{$user->name}}"
                             src="{{$user->profile_photo_url}}">
                    </div>
                    <div class="col-md-8">
                        <h2>Dados Pessoais</h2>

                        Nome: {{$user->name}}<br>
                        Função: @foreach($user->roles as $role)
                            <span
                                class="badge bg-blue">
                                {{\App\Service\Enum\RoleOptions::getRoleOption($role->name)}}</span>
                        @endforeach
                        @if($user->banned_at!= null)
                            <span class="badge bg-danger">BAN</span>
                        @endif
                        <br>
                        Email: {{$user->email}}<br>
                        Data de Nascimento: {{$user->birthday?->format('d/m/y')}}<br>
                        Data de Cadastro: {{$user->created_at?->format('d/m/y H:i')}}<br>
                        Data de Atualização: {{$user->updated_at?->format('d/m/y H:i')}}<br>
                        Celular: {{$user?->phone}} @if($user->phone)
                            <a href="https://api.whatsapp.com/send?phone={{numberClear($user->phone)}}"
                               title="(Enviar mensagem no WhatsApp)"><i
                                    class="fab fa-whatsapp"></i></a>
                            <a href="https://t.me/+{{numberClear($user->phone)}}"
                               title="(Enviar mensagem no Telegram)"><i
                                    class="fab fa-telegram"></i></a>
                        @endif<br>


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
