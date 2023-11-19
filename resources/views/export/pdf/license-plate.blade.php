{{--Autorização de Placa--}}

<style>
    hr {
        width: 200%;
        position: relative;
        left: -50%;
    }
</style>

<div class='main'>
    @foreach ($streets as $street)
        @if ($street['even_people'])
            @foreach ($street['even_people'] as $person)
                <div class='item-placa'>
                    <h2 class='center-align'>
                        AUTORIZA CANDIDATO (A)
                    </h2>
                    <h2 class='center-align'>
                        {{ strtoupper($empresa->nome) }}
                    </h2>
                    <h3 class='center-align'>
                        A COLOCAR EM SEU IMÓVEL, PROPAGANDA ELEITORAL, CONFORME DETERMINA
                    </h3>
                    <h3 class='center-align'>
                        A LEI ELEITORAL Nº N° 9504/97 E A RESOLUÇÃO TSE 23551/17, de 18/12/2019.
                    </h3>
                    <h3 style='margin: 3px;'>Nome: {{ $person['nome'] }}</h3>
                    <h3 style='margin: 3px;'>Endereço: {{ $person['endereco_sem_cep'] }}</h3>
                    <h3 style='margin: 3px;'>Telefone: ________________________  Data Nascimento: {{ date_format($person['data_aniversario'], 'd/m/Y') }}</h3></br>
                    <h2 class='center-align' style='margin: 3px;'>________________________________</h2>
                    <h3 class='center-align' style='margin: 3px;'>ASSINATURA</h3>
                    <h3 class='center-align'>DATA:&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;{{ now()->year }}</h3>
                    <p class='right-align'>{{ $person['id'] }}@if(in_array('1 AUTORIZA PLACA', $person->grupos->pluck('nome')->toArray()))SIM @else NÃO @endif</p>
                </div>
                <hr style='border: 1px dashed;'>
            @endforeach
        @endif

        @if ($street['odd_people'])
            @foreach ($street['odd_people'] as $person)
                <div class='item-placa'>
                    <h2 class='center-align'>
                        AUTORIZA CANDIDATO (A)
                    </h2>
                    <h2 class='center-align'>
                        {{ strtoupper($empresa->nome) }}
                    </h2>
                    <h3 class='center-align'>
                        A COLOCAR EM SEU IMÓVEL, PROPAGANDA ELEITORAL, CONFORME DETERMINA
                    </h3>
                    <h3 class='center-align'>
                        A LEI ELEITORAL Nº N° 9504/97 E A RESOLUÇÃO TSE 23551/17, de 18/12/2019.
                    </h3>
                    <h3 style='margin: 3px;'>Nome: {{ $person['nome'] }}</h3>
                    <h3 style='margin: 3px;'>Endereço: {{ $person['endereco_sem_cep'] }}</h3>
                    <h3 style='margin: 3px;'>Telefone: ________________________  Data Nascimento: {{ date_format($person['data_aniversario'], 'd/m/Y') }}</h3></br>
                    <h2 class='center-align' style='margin: 3px;'>________________________________</h2>
                    <h3 class='center-align' style='margin: 3px;'>ASSINATURA</h3>
                    <h3 class='center-align'>DATA:&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;{{ now()->year }}</h3>
                    <p class='right-align'>{{ $person['id'] }}@if(in_array('1 AUTORIZA PLACA', $person->grupos->pluck('nome')->toArray()))SIM @else NÃO @endif</p>
                </div>
                <hr style='border: 1px dashed;'>
            @endforeach
        @endif
    @endforeach
</div>
