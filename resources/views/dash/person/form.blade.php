<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Eleitores') }}
        </h2>
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
{{--    @if($form['method']!=='POST')--}}
{{--        <form action="{{route('dash.checkin.store')}}" method="POST">--}}
{{--            @csrf--}}
{{--            <input type="hidden" value="{{$person->pid}}" name="voter_pid"/>--}}
{{--            <button type="submit" class="btn btn-success">--}}
{{--                <i class="fa fa-check"></i>--}}
{{--                Checkin--}}
{{--            </button>--}}
{{--        </form>--}}
{{--    @endif--}}
    <form action="{{route($form['route'][0],(isset($form['route']['person']))?$form['route']['person']:null)}}"
          method="POST">
        @method($form['method'])
        @csrf
        <fieldset>
            <legend>Dados Principais</legend>
            <div class="row">
                <div class="form-group mb-3 col-md-3">
                    <label for="cel" class="form-label">Celular</label>
                    <input type="text" name="cel" class="form-control tel @error('cel') is-invalid @enderror" id="cel"
                           placeholder=""
                           value="{{$person->cel??old('cel')}}">
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
                        <option value="m" {{$person?->sex=='m'?'selected':null}}>Masculino</option>
                        <option value="f" {{$person?->sex=='f'?'selected':null}}>Feminino</option>
                        <option value="o" {{$person?->sex=='o'?'selected':null}}>Outro</option>
                    </select>
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="birth_date" class="form-label">Data de nascimento</label>
                    <input type="date" name="birth_date"
                           class="form-control date @error('birth_date') is-invalid @enderror" id="birth_date"
                           placeholder=""
                           value="{{$person->birth_date??old('birth_date')}}">
                </div>
                <div class="form-group mb-3 col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" placeholder=""
                           value="{{$person->email??old('email')}}">
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="tel" class="form-label">Telefone</label>
                    <input type="text" name="tel" class="form-control tel @error('tel') is-invalid @enderror" id="tel"
                           placeholder=""
                           value="{{$person->tel??old('tel')}}">
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
        <fieldset>
            <legend>Endereço</legend>
            <div class="row">
                <div class="form-group mb-3 col-md-3">
                    <label for="post_code" class="form-label">CEP</label>
                    <input type="text" name="zipcode"
                           class="form-control cep @error('zipcode') is-invalid @enderror" id="zipcode"
                           placeholder=""
                           onblur="getCep(this.value);"
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


        <fieldset>
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

                @can('send_file')
                    <div class="form-group mb-3 col-md-12">
                        <label for="media" class="form-label">Foto</label>
                        <x-media-library-attachment name="media" rules="mimes:png,jpeg"/>
                    </div>
                @endcan
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
    <script>
        function getCep(cep) {
            axios.post('{{route('ajax.getCep')}}', {cep: cep})
                .then(function (r) {

                    console.log(r.data);

                    document.getElementById('street').value = r.data.logradouro;
                    document.getElementById('city').value = r.data.localidade;
                    document.getElementById('district').value = r.data.bairro;
                    document.getElementById('state').value = r.data.uf;
                    document.getElementById('complement').value = r.data.complemento;
                });
        };
    </script>
</x-app-layout>
