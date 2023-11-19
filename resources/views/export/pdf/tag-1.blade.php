<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} {{$tag_name??null}}</title>
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

    </style>
</head>
<body>
@foreach($data->chunk(3) as $tags)

    @foreach($tags as $tag)
        <div class="pdf-container">
            <div class="pdf-item">
                <h2>{{$tag->name}}</h2>
                <p>{{$tag->address->street}}, {{$tag->address->number}}</p>
                <p>{{$tag->address->district}}</p>
                <p>{{$tag->address->zipcode}}</p>
                <p>{{$tag->address->city}}, {{$tag->address->uf}}</p>
            </div>
        </div>
    @endforeach

@endforeach
</body>
</html>
