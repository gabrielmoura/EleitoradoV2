<!doctype html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}} {{$tag_name??null}}</title>
{{--    <link href="@vite('resources/scss/app.scss')" rel="stylesheet">--}}
</head>
<body>
@foreach($tags as $tag)
    <div style="position:absolute;top:0.65in;left:0.48in;width:1.64in;line-height:0.11in;"><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000">{{$tag->name}}</span><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000"> </span><br/></SPAN>
    </div>
    <div style="position:absolute;top:0.65in;left:2.67in;width:0.28in;line-height:0.11in;"><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000">{{$tag->pid}}</span><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000"> </span><br/></SPAN>
        {{-- Por Um QR Code Talvez seja melhor --}}
    </div>
    <div style="position:absolute;top:0.86in;left:0.48in;width:1.09in;line-height:0.11in;"><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000">{{$tag->address->street}}, {{$tag->address->number}}</span><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000"> </span><br/></SPAN>
    </div>
    <div style="position:absolute;top:1.07in;left:0.48in;width:0.79in;line-height:0.11in;"><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000">{{$tag->address->district}}</span><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000"> </span><br/></SPAN>
    </div>
    <div style="position:absolute;top:1.28in;left:0.48in;width:0.43in;line-height:0.11in;"><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000">{{$tag->address->zipcode}}</span><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000"> </span><br/></SPAN>
    </div>
    <div style="position:absolute;top:1.28in;left:2.03in;width:0.91in;line-height:0.11in;"><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000">{{$tag->address->city}}, {{$tag->address->uf}}</span><span
            style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Helvetica;color:#000000"> </span><br/></SPAN>
    </div>
@endforeach
</body>
</html>
