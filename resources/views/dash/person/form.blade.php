<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <h2 class="h4 font-weight-bold">
                    {{ __('Eleitores') }}
                </h2>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{$form['route']}}" method="POST">
        @method($form['method'])
        @csrf
        <fieldset class="mb-3">
            <legend>Dados Principais</legend>
            <div class="row">
                <div class="form-group mb-3 col-md-3">
                    <label for="cel" class="form-label">Celular</label>
                    <input type="text" name="cellphone"
                           class="form-control tel @error('cellphone') is-invalid @enderror" id="cellphone"
                           placeholder=""
                           value="{{$person->cellphone??old('cellphone')}}">
                </div>
                <div class="from-group mb-3  col-md-6">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                           placeholder=""
                           value="{{$person->name??old('name')}}">
                </div>
                <div class="form-group mb-3  col-md-3">
                    <label for="sex" class="form-label">Sexo</label>
                    <select class="select form-control" name="sex">
                        @foreach(\App\Service\Enum\PersonOptions::getSexOptions() as $key=>$value)
                            <option value="{{$value}}" {{$person?->sex===$value?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="dateOfBirth" class="form-label">Data de nascimento</label>
                    <input type="date" name="dateOfBirth"
                           class="form-control  @error('dateOfBirth') is-invalid @enderror" id="dateOfBirth"
                           placeholder=""
                           value="{{old('dateOfBirth',$person->dateOfBirth->format('Y-m-d'))}}">
                </div>
                <div class="form-group mb-3 col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" placeholder=""
                           value="{{$person->email??old('email')}}">
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="tel" class="form-label">Telefone</label>
                    <input type="text" name="telephone"
                           class="form-control tel @error('telephone') is-invalid @enderror" id="telephone"
                           placeholder=""
                           value="{{$person->telephone??old('telephone')}}">
                </div>
            </div>
            <div class="row">
                <div class="form-group mb-3 col-md-6">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" name="cpf" class="form-control cpf" id="cpf" placeholder=""
                           value="{{$person->cpf??old('cpf')}}">
                </div>
                <div class="form-group mb-3 col-md-6">
                    <label for="rg" class="form-label">RG</label>
                    <input type="text" name="rg" class="form-control rg" id="rg" placeholder=""
                           value="{{$person->rg??old('rg')}}">
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-3">
            <legend>Endereço</legend>
            <div class="row">
                <div class="form-group mb-3 col-md-3">
                    <label for="post_code" class="form-label">CEP</label>
                    <input type="text" name="zipcode"
                           class="form-control cep @error('zipcode') is-invalid @enderror" id="zipcode"
                           placeholder=""
                           onblur="helpers.getCep(this.value);"
                           value="{{$person->address->zipcode??old('post_code')}}"
                    >
                </div>

                <div class="form-group mb-3 col-md-6">
                    <label for="street" class="form-label">Logradouro</label>
                    <input type="text" name="street" class="form-control @error('street') is-invalid @enderror"
                           id="street"
                           placeholder=""
                           value="{{$person->address->street??old('street')}}"
                    >
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="email" class="form-label">Numero</label>
                    <input type="number" name="number" class="form-control  @error('number') is-invalid @enderror"
                           id="number"
                           placeholder=""
                           value="{{$person->address->number??old('number')}}"
                    >
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="complement" class="form-label">Complemento</label>
                    <input type="text" name="complement" class="form-control @error('complement') is-invalid @enderror"
                           id="complement" placeholder=""
                           value="{{$person->address->complement??old('complement')}}"
                    >
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="district" class="form-label">Bairro</label>
                    <input type="text" name="district" class="form-control @error('district') is-invalid @enderror"
                           id="district" placeholder=""
                           value="{{$person->address->district??old('district')}}"
                    >
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="city" class="form-label">Cidade</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="city"
                           placeholder=""
                           value="{{$person->address->city??old('city')}}"
                    >
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="state" class="form-label">Estado</label>
                    <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" id="state"
                           placeholder=""
                        {{--                           value="{{$person->addresses->last()->state??old('state')}}"--}}
                    >
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-3">
            <legend>Dados Eleitorais</legend>
            <div class="row">
                <div class="form-group mb-3 col-md-4">
                    <label for="voter_zone" class="form-label">Zona Eleitoral</label>
                    <input type="text" name="voter_zone" class="form-control @error('voter_zone') is-invalid @enderror"
                           id="voter_zone"
                           placeholder=""
                           value="{{$person->voter_zone??old('voter_zone')}}"/>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="voter_section" class="form-label">Seção Eleitoral</label>
                    <input type="text" name="voter_section"
                           class="form-control @error('voter_section') is-invalid @enderror" id="voter_section"
                           placeholder=""
                           value="{{$person->voter_section??old('voter_section')}}"/>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="voter_registration" class="form-label">Registro Eleitoral</label>
                    <input type="text" name="voter_registration"
                           class="form-control @error('voter_registration') is-invalid @enderror"
                           id="voter_registration"
                           placeholder=""
                           value="{{$person->voter_registration??old('voter_registration')}}"/>
                </div>
            </div>

            <div class="row">
                <div class="form-group mb-3 col-md-4">
                    <label for="skinColor" class="form-label">Cor da Pele</label>
                    <select name="skinColor" id="skinColor" class="form-control">
                        <option value="">Selecione</option>
                        @foreach(\App\Service\Enum\PersonOptions::getSkinColorOptions() as $key=>$value)
                            <option
                                value="{{$value}}" {{(isset($person)&&$person->maritalStatus==$value)?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="maritalStatus" class="form-label">Estado Civil</label>
                    <select name="maritalStatus" id="maritalStatus" class="form-control">
                        <option value="">Selecione</option>
                        @foreach(\App\Service\Enum\PersonOptions::getMaritalStatusOptions() as $key=>$value)
                            <option
                                value="{{$value}}" {{(isset($person)&&$person->maritalStatus==$value)?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="educationLevel" class="form-label">Escolaridade</label>
                    <select name="educationLevel" id="educationLevel" class="form-control">
                        <option value="">Selecione</option>
                        @foreach(\App\Service\Enum\PersonOptions::getEducationLevelOptions() as $key=>$value)
                            <option
                                value="{{$value}}" {{(isset($person)&&$person->maritalStatus==$value)?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="occupation" class="form-label">Ocupação</label>
                    <select name="occupation" id="occupation" class="form-control">
                        <option value="">Selecione</option>
                        @foreach(\App\Service\Enum\PersonOptions::getOccupationOptions() as $key=>$value)
                            <option
                                value="{{$value}}" {{(isset($person)&&$person->maritalStatus==$value)?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="religion" class="form-label">Religião</label>
                    <select name="religion" id="religion" class="form-control">
                        <option value="">Selecione</option>
                        @foreach(\App\Service\Enum\PersonOptions::getReligionOptions() as $key=>$value)
                            <option
                                value="{{$value}}" {{(isset($person)&&$person->maritalStatus==$value)?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="housing" class="form-label">Moradia</label>
                    <select name="housing" id="housing" class="form-control">
                        <option value="">Selecione</option>
                        @foreach(\App\Service\Enum\PersonOptions::getHousingOptions() as $key=>$value)
                            <option
                                value="{{$value}}" {{(isset($person)&&$person->maritalStatus==$value)?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="sexualOrientation" class="form-label">Orientação Sexual</label>
                    <select name="sexualOrientation" id="sexualOrientation" class="form-control">
                        <option value="">Selecione</option>
                        @foreach(\App\Service\Enum\PersonOptions::sexualOrientationOptions() as $key=>$value)
                            <option
                                value="{{$value}}" {{(isset($person)&&$person->maritalStatus==$value)?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="genderIdentity" class="form-label">Identidade de Gênero</label>
                    <select name="genderIdentity" id="genderIdentity" class="form-control">
                        <option value="">Selecione</option>
                        @foreach(\App\Service\Enum\PersonOptions::genderIdentityOptions() as $key=>$value)
                            <option
                                value="{{$value}}" {{(isset($person)&&$person->maritalStatus==$value)?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-4">
                    <label for="deficiencyType" class="form-label">Tipo de Deficiência</label>
                    <select name="deficiencyType" id="deficiencyType" class="form-control">
                        <option value="">Selecione</option>
                        @foreach(\App\Service\Enum\PersonOptions::getDeficiencyTypeOptions() as $key=>$value)
                            <option
                                value="{{$value}}" {{(isset($person)&&$person->maritalStatus==$value)?'selected':null}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-3">
            <legend>Dados Adicionais</legend>
            <div class="row">
                <div class="form-group mb-3 col-md-12">
                    <label for="tags[]" class="form-label">Grupos associados</label>
                    <select class="tselect-multi" name="groups[]" multiple="multiple">
                        @foreach($groups as $group)
                            <option
                                value="{{$group->id}}"
                                {{(isset($person)&&$person->groups->contains( fn($value,$key)=>$value->name==$group->name))?'selected':null}}>
                                > {{$group->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3 col-md-12">
                    <label for="events[]" class="form-label">Eventos associados</label>
                    <select class="form-control tselect-multi" name="events[]" multiple="multiple">
                        @foreach($events as $event)
                            <option
                                value="{{$event->id}}"
                                {{(isset($person)&&$person->events->contains( fn($value,$key)=>$value->name==$event->name))?'selected':null}}>
                                {{$event->name}}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group mb-3 col-md-12">
                    <label for="avatar" class="form-label">Foto</label>
                    <x-media-library-attachment name="avatar" rules="mimes:jpeg,png,jpg|max:2048" max-items="1" editableName/>
                </div>

                @can('add_property')
                    <div class="form-group mb-3 col-md-12">
                        @if(isset($voter?->properties))
                            @foreach($voter?->properties as $property)
                                {{$property}}
                            @endforeach
                        @endif
                        <label for="inputNameElement" class="form-label">Adicionar Campo</label>
                        <br/>
                        <input id="inputNameElement"/>

                        <a onclick="createInput(document.getElementById('setElementDiv'),document.getElementById('inputNameElement').value,'properties');document.getElementById('inputNameElement').value=null;"
                           class="btn btn-outline-secondary btn-sm">
                            Adicionar Campo
                        </a>
                        <div class="col-md-4" id="setElementDiv"></div>
                    </div>
                @endcan
            </div>
        </fieldset>

        <div class="form-group mb-3 col">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</x-app-layout>
