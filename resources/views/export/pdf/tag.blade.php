<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}} {{$tag_name??null}}</title>
    @vite('resources/scss/app.scss')
    <style>
        :root {
            --blue: #1e90ff;
            --white: #ffffff;
            --bs-body-color: #000000;
            --bs-body-bg: #ffffff;
        }

        body {
            font-family: 'figtree', sans-serif;
            font-size: 12px;
            display: block;
        }

    </style>
</head>
<body>
@foreach($data->chunk(3) as $tags)
    <div class="row">
        @foreach($tags as $tag)
            <div class="col-4">
                <div class="row ">
                    <div class="col-6 text-start"><p
                            class="text-monospace text-uppercase">{{$tag->name}}</p></div>
                    <div class="col-6">
                        <p class="text-end">
                            {!! \App\Actions\Tools\QrCode::genSvg(route('dash.person.show',$tag->pid),50) !!}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <span>{{$tag->address->street}}, {{$tag->address->number}}</span>
                </div>

                <div class="row">
                    <span>{{$tag->address->district}}</span>
                </div>

                <div class="row">
                    <div class="col-6 text-start">
                        <span>{{$tag->address->zipcode}}</span>
                    </div>
                    <div class="col-6 text-end">
                        <span>{{$tag->address->city}}, {{$tag->address->uf}}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
</body>
</html>
