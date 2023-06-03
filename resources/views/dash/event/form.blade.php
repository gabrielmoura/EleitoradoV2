<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Eventos') }}
        </h2>
    </x-slot>
    <form action="{{route($form['route'][0],(isset($form['route']['event']))?$form['route']['event']:null)}}"
          method="POST">
        @method($form['method'])
        @csrf
        <fieldset>
            <legend>Evento</legend>
            <div class="row">
                <div class="from-group mb-3  col-md-6">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                           placeholder=""
                           value="{{$event->name??old('name')}}">
                    @if($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                </div>
                <div class="from-group mb-3  col-md-6">
                    <label for="start_time" class="form-label">Inicio</label>
                    <input type="text" name="start_time"
                           class="form-control date-time @error('start_time') is-invalid @enderror" id="start_time"
                           placeholder=""
                           value="{{$event->start_time??old('start_time')}}">
                    @if($errors->has('start_time'))
                        <em class="invalid-feedback">
                            {{ $errors->first('start_time') }}
                        </em>
                    @endif
                </div>
                <div class="from-group mb-3  col-md-6">
                    <label for="end_time" class="form-label">Fim</label>
                    <input type="text" name="end_time"
                           class="form-control date-time @error('end_time') is-invalid @enderror" id="end_time"
                           placeholder=""
                           value="{{$event->end_time??old('end_time')}}">
                    @if($errors->has('end_time'))
                        <em class="invalid-feedback">
                            {{ $errors->first('end_time') }}
                        </em>
                    @endif
                </div>

                <div class="form-group mb-3 col-md-6">
                    <label for="recurrence" class="form-label">Recorrencia *</label>
                    <select class="select form-control @error('recurrence') is-invalid @enderror" name="recurrence">
                        @foreach(\App\Models\Event::RECURRENCE_RADIO as $key => $label)
                            <option value="{{$key}}"
                                {{(isset($event)&&$event->recurrence==$key)?'selected':null}}>{{$label}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea name="description" title="Descrição"
                              class="form-control col-md-12 @error('description') is-invalid @enderror">{!! $event->description??old('description') !!}</textarea>
                </div>


            </div>
        </fieldset>
        <fieldset>

            <legend>Endereço</legend>
            <div class="row">
                <div class="form-group mb-3 col-md-3">
                    <label for="post_code" class="form-label">CEP</label>
                    <input type="text" name="post_code" class="form-control cep @error('post_code') is-invalid @enderror" id="post_code"
                           placeholder=""
                           onblur="getCep(this.value);"
                           value="{{$event->address->post_code??old('post_code')}}">
                </div>
                <div class="form-group mb-3 col-md-6">
                    <label for="street" class="form-label">Logradouro</label>
                    <input type="text" name="street" class="form-control @error('street') is-invalid @enderror"
                           id="street"
                           placeholder=""
                           value="{{$event->address->street??old('street')}}">
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="email" class="form-label">Numero</label>
                    <input type="number" name="number" class="form-control  @error('number') is-invalid @enderror"
                           id="number"
                           placeholder=""
                           value="{{$event->address->number??old('number')}}">
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="complement" class="form-label">Complemento</label>
                    <input type="text" name="complement" class="form-control @error('complement') is-invalid @enderror"
                           id="complement" placeholder=""
                           value="{{$event->address->complement??old('complement')}}">
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="district" class="form-label">Bairro</label>
                    <input type="text" name="district" class="form-control @error('district') is-invalid @enderror"
                           id="district" placeholder=""
                           value="{{$event->address->district??old('district')}}">
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="city" class="form-label">Cidade</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="city"
                           placeholder=""
                           value="{{$event->address->city??old('city')}}">
                </div>
                <div class="form-group mb-3 col-md-3">
                    <label for="state" class="form-label">Estado</label>
                    <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" id="state"
                           placeholder=""
                           value="{{$event->address->state??old('state')}}">
                </div>
            </div>
        </fieldset>
        <div class="mb-3">
            <button type="submit">Enviar</button>
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
