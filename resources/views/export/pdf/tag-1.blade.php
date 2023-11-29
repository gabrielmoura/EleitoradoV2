<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} {{$tag_name??null}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .pdf-item {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
        }

        .pdf-item h2 {
            margin: 0;
            font-size: 18px;
        }

        .pdf-item p {
            margin: 5px 0;
            font-size: 14px;
        }

        .page-break {
            display: block;
            clear: both;
            page-break-after: always;
        }

    </style>
</head>
<body>
<div class="container">
    @foreach($data->chunk(12) as $line)
        @foreach($line->chunk(3) as $tags)
            {{--        Linha--}}
            <div class="row">
                @foreach($tags as $tag)
                    <div class="col s4">
                        <div class="pdf-container">
                            <div class="pdf-item">
                                <h2>{{$tag->name}}</h2>
                                <p>{{$tag->address->street}}, {{$tag->address->number}}</p>
                                <p>{{$tag->address->district}}</p>
                                <p>{{$tag->address->zipcode}}</p>
                                <p>{{$tag->address->city}}, {{$tag->address->uf}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        <div class="page-break"></div>
    @endforeach
</div>
</body>
</html>
