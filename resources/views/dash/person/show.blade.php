<x-app-layout>

    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="me-1 fad fa-person-sign"></i>
                        </div>
                        Pessoa: {{$person->name}}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    {{--                    <a class="btn btn-sm btn-light text-primary" href="{{route('dash.group.index')}}">--}}
                    {{--                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"--}}
                    {{--                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"--}}
                    {{--                             class="feather feather-users me-1">--}}
                    {{--                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>--}}
                    {{--                            <circle cx="9" cy="7" r="4"></circle>--}}
                    {{--                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>--}}
                    {{--                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>--}}
                    {{--                        </svg>--}}
                    {{--                        Listar Grupos--}}
                    {{--                    </a>--}}
                    <button class="btn btn-sm btn-light text-primary" data-bs-toggle="modal"
                            data-bs-target="#createModal">

                        <i class="me-1 fad fa-hand-holding-magic"></i>
                        Criar Demanda
                    </button>

                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <livewire:demand.create :person="$person"/>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="card">
            <div class="card-header">
                <h3 class="text-start text-xl">{{$person->name}}</h3>
            </div>
            <div class="card-body m-3">
                <div class="row">
                    <div class="col-md-4">
                        <img width="210px" height="250px" class="avatar-img img-thumbnail m-1" alt="{{$person->name}}"
                             src="{{$person->image}}">
                    </div>
                    <div class="col-md-4">
                        <h2>Dados Pessoais</h2>
                        Nascimento: {{$person->birth_date}} |
                        Sexo: {{\App\Service\Enum\PersonOptions::getSexOption($person->sex)}}<br>
                        Email: {{$person->email}}<br>
                        Data de Cadastro: {{$person->created_at}}<br>
                        Data de Atualização: {{$person->updated_at}}<br>
                        Telefone: {{$person?->telephone}} | Celular: {{$person?->cellphone}} @if($person->cellphone)
                            <a href="https://api.whatsapp.com/send?phone=55{{numberClear($person->cellphone)}}"
                               title="(Enviar mensagem no WhatsApp)"><i
                                    class="fab fa-whatsapp"></i></a>
                            <a href="https://t.me/+55{{numberClear($person->cellphone)}}"
                               title="(Enviar mensagem no Telegram)"><i
                                    class="fab fa-telegram"></i></a>
                        @endif<br>
                        Endereço Completo: {{$person->address?->street}} - {{$person->address?->number}}
                        - {{$person->address?->district}} - {{$person->address?->city}} - {{$person->address?->state}}
                        <br>
                        CEP: {{$person->address?->zipcode}} @if($person->address?->latitude && $person->address?->longitude)
                            <a href="https://www.google.com/maps/search/?api=1&query={{$person->address->latitude}},{{$person->address->longitude}}">(Visualizar
                                no Mapa)</a>
                        @endif <br>


                    </div>
                    <div class="col-md-4">
                        <h2>Dados Eleitorais</h2>
                        Título de Eleitor: {{$person->voter_registration}}<br>
                        Zona Eleitoral: {{$person->electoral_zone}}<br>
                        Seção Eleitoral: {{$person->electoral_section}}<br>

                        Cor da Pele: {{\App\Service\Enum\PersonOptions::getSkinColorOption($person->skinColor)}}<br>
                        Estado
                        Civil: {{\App\Service\Enum\PersonOptions::getMaritalStatusOption($person->maritalStatus) }}<br>
                        Escolaridade: {{\App\Service\Enum\PersonOptions::getEducationLevelOption($person->educationLevel) }}
                        <br>
                        Ocupação: {{\App\Service\Enum\PersonOptions::getOccupationOption($person->occupation) }}<br>
                        Religião: {{\App\Service\Enum\PersonOptions::getReligionOption($person->religion) }}<br>
                        Moradia: {{\App\Service\Enum\PersonOptions::getHouseOption($person->housing) }}<br>
                        Orientação
                        Sexual: {{\App\Service\Enum\PersonOptions::getSexualOrientationOption($person->sexualOrientation) }}
                        <br>
                        Identidade de
                        Gênero: {{\App\Service\Enum\PersonOptions::getGenderIdentityOption($person->genderIdentity) }}
                        <br>
                        Tipo de
                        Deficiência: {{\App\Service\Enum\PersonOptions::getDeficiencyTypeOption($person->deficiencyType) }}
                        <br>

                    </div>
                </div>
                <div class="row">
                    <h3>Grupos Associados</h3>
                    <table class="table table-responsive-md table-bordered ml-3">
                        <tbody>
                        @forelse($person->groups->take(10) as $group)
                            <tr>
                                <td><a href="{{route('dash.group.show',['group'=>$group->pid])}}">{{$group->name}}</a>
                                </td>
                                <td>{{date('d-m-Y', strtotime($group->pivot->checked_at))}}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm"
                                            onclick="helpers.checkPersonAndGroup('{{$person->id}}','{{$group->id}}')"
                                    >Check
                                    </button>

                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            onclick="helpers.unCheckPersonAndGroup('{{$person->id}}','{{$group->id}}')"
                                    >Remover
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>Nenhum Grupo encontrado</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <h3>Eventos Frequentados</h3>
                    <table class="table table-responsive-md table-bordered ml-3">
                        <tbody>
                        @forelse($person->events->take(10) as $event)
                            <tr>
                                <td>{{$event->name}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td>Nenhum evento encontrado</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
