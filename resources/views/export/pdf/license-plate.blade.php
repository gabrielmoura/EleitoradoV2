<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        hr {
            width: 100%;
            position: relative;
        }

        .image-padding {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: center;
        }

        #mail-title {
            margin-bottom: 3px;
        }

        #cke_mail-body {
            margin-bottom: 30px;
        }

        #is_guest + div {
            width: 100%;
        }

        .dados-principais {
            margin-bottom: 1px;
            overflow: auto;
        }

        .transform-upper-case {
            text-transform: uppercase
        }

        .item-placa {
            height: 50rem;
        }
    </style>
</head>
<body>
<div class='main'>
    @foreach ($streets as $street => $people)
        @if ($people['even_address'])
            @foreach ($people['even_address'] as $person)
                <div class='item-placa'>
                    <h2 class='center-align'>
                        AUTORIZA CANDIDATO (A)
                    </h2>
                    <h2 class='center-align'>
                        {{ strtoupper($company->name) }}
                    </h2>
                    <h3 class='center-align'>
                        A COLOCAR EM SEU IMÓVEL, PROPAGANDA ELEITORAL, CONFORME DETERMINA
                    </h3>
                    <h3 class='center-align'>
                        A LEI ELEITORAL Nº N° 9504/97 E A RESOLUÇÃO TSE 23551/17, de 18/12/2019.
                    </h3>
                    <h3 style='margin: 3px;'>Nome: {{ $person->name }}</h3>
                    <h3 style='margin: 3px;'>Endereço: {{ $person?->address?->full_address }}</h3>
                    <h3 style='margin: 3px;'>Telefone: ________________________ Data
                        Nascimento: {{ $person->dateOfBirth?->format('d/m/Y') }}</h3></br>
                    <h2 class='center-align' style='margin: 3px;'>________________________________</h2>
                    <h3 class='center-align' style='margin: 3px;'>ASSINATURA</h3>
                    <h3 class='center-align'>
                        DATA:&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;{{ now()->year }}</h3>
                    <p class='right-align'>{{ $person['id'] }}
                        @if(in_array('1 AUTORIZA PLACA', $person->groups->pluck('nome')->toArray()))
                            SIM
                        @else
                            NÃO
                        @endif</p>
                </div>
                <hr style='border: 1px dashed;'>
            @endforeach
        @endif

        @if ($people['odd_address'])
            @foreach ($people['odd_address'] as $person)
                <div class='item-placa'>
                    <h2 class='center-align'>
                        AUTORIZA CANDIDATO (A)
                    </h2>
                    <h2 class='center-align'>
                        {{ strtoupper($company->name) }}
                    </h2>
                    <h3 class='center-align'>
                        A COLOCAR EM SEU IMÓVEL, PROPAGANDA ELEITORAL, CONFORME DETERMINA
                    </h3>
                    <h3 class='center-align'>
                        A LEI ELEITORAL Nº N° 9504/97 E A RESOLUÇÃO TSE 23551/17, de 18/12/2019.
                    </h3>
                    <h3 style='margin: 3px;'>Nome: {{ $person->name }}</h3>
                    <h3 style='margin: 3px;'>Endereço: {{ $person?->address?->full_address }}</h3>
                    <h3 style='margin: 3px;'>Telefone: ________________________ Data
                        Nascimento: {{ $person->dateOfBirth?->format('d/m/Y') }}</h3></br>
                    <h2 class='center-align' style='margin: 3px;'>________________________________</h2>
                    <h3 class='center-align' style='margin: 3px;'>ASSINATURA</h3>
                    <h3 class='center-align'>
                        DATA:&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;{{ now()->year }}</h3>
                    <p class='right-align'>{{ $person['id'] }}
                        @if(in_array('1 AUTORIZA PLACA', $person->groups->pluck('nome')->toArray()))
                            SIM
                        @else
                            NÃO
                        @endif</p>
                </div>
                <hr style='border: 1px dashed;'>
            @endforeach
        @endif
    @endforeach
</div>
</body>
</html>
