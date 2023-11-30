<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-industry-alt fa-lg"></i>
                        </div>
                        Empresa {{$company->name}}
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
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
                    <select class="select form-control @error('recurrence') is-invalid @enderror" name="recurrence"
                            id="recurrence">
                        @foreach(\App\Service\Enum\EventOptions::RECURRENCE_RADIO as $key => $label)
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
        <div class="mb-3">
            <button type="submit">Enviar</button>
        </div>
    </form>
</x-app-layout>
