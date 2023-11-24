<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .pdf-street {
            background-color: #EAE4E4;
            padding-top: 10px;
            padding-bottom: 10px;
            color: #ADAAAA;
        }

        th.th-pdf {
            font-size: 18px;
        }

        td.td-pdf {
            font-size: 15px;
        }

        /*th, td {*/
        /*    padding: 18px;*/
        /*}*/

        /*tr {*/
        /*    page-break-inside: avoid;*/
        /*}*/

        /*body {*/
        /*    background-color: #ffffff;*/
        /*}*/

        .page-break {
            display: block;
            clear: both;
            page-break-after: always;
        }
    </style>
</head>
<body>
<div class='container'>
    <div class='section'>
        <h1 class="center-align">Relatório Puxada</h1>
        @foreach ($streets as $street => $people)

            @if ($people['even_address'])
                <div class='row'>
                    <h2 class='pdf-street'>
                        {{ $street }} - Pares
                    </h2>
                    <table cellpadding="20">
                        <thead>
                        <tr>
                            <th width='30%' class='th-pdf'>nome</th>
                            <th width='30%' class='th-pdf'>endereço</th>
                            <th width='10%' class='th-pdf'>telefones</th>
                            <th width='10%' class='th-pdf'>nascimento</th>
                            <th width='10%' class='th-pdf'>atualização</th>
                            <th width='10%' class='th-pdf'>código</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($people['even_address'] as $person)

                            <tr>
                                <td class='td-pdf'>{{ $person->name ? strtoupper($person->name) : '' }}</td>
                                <td class='td-pdf'>{{ $person?->address?->full_address }}</td>
                                <td class='td-pdf'>{{ $person->cellphone }} {{ $person->telephone }}</td>
                                <td class='td-pdf'>{{ $person->dateOfBirth ? $person->dateOfBirth->format('d/m/Y') : '' }}</td>
                                <td class='td-pdf'>
                                    {{\Illuminate\Support\Carbon::parse($person->groups->first()->pivot?->checked_at)->format('d/m/Y')}}
                                    {{--                                Data da Atualização--}}
                                </td>
                                <td class='td-pdf'>{{ $person->pid }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="page-break"></div>

            @if ($people['odd_address'])
                <div class='row'>
                    <h2 class='pdf-street'>{{ $street }} - Ímpares</h2>
                    <table cellpadding="100">
                        <thead>
                        <tr>
                            <th width='30%' class='th-pdf'>nome</th>
                            <th width='30%' class='th-pdf'>endereço</th>
                            <th width='10%' class='th-pdf'>telefones</th>
                            <th width='10%' class='th-pdf'>nascimento</th>
                            <th width='10%' class='th-pdf'>atualização</th>
                            <th width='10%' class='th-pdf'>código</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($people['odd_address'] as $person)
                            <tr>
                                <td class='td-pdf'>{{ $person->name ? strtoupper($person->name) : '' }}</td>
                                <td class='td-pdf'>{{ $person?->address?->full_address }}</td>
                                <td class='td-pdf'>{{ $person->cellphone }} {{ $person->telephone }}</td>
                                <td class='td-pdf'>{{ $person->dateOfBirth ? $person->dateOfBirth->format('d/m/Y') : '' }}</td>
                                <td class='td-pdf'>
                                    {{\Illuminate\Support\Carbon::parse($person->groups->first()->pivot?->checked_at)->format('d/m/Y')}}
                                </td>
                                <td class='td-pdf'>{{ $person->pid }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @unless ($loop->last)
                <div class="page-break"></div>
            @endunless
        @endforeach
    </div>
</div>
</body>
</html>
