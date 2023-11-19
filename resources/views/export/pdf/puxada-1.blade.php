<div class='section'>
    <h1 class="center-align">Relatório Puxada</h1>
    @foreach ($streets as $street => $people)
        @if ($people['even_people'])
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
                    @foreach ($people['even_people'] as $person)
                        <tr>
                            <td class='td-pdf'>{{ $person->nome ? strtoupper($person->nome) : '' }}</td>
                            <td class='td-pdf'>{{ formated_endereco($person) }}</td>
                            <td class='td-pdf'>{{ $person->celular }} {{ $person->telefone }}</td>
                            <td class='td-pdf'>{{ $person->data_aniversario ? $person->data_aniversario->format('d/m/Y') : '' }}</td>
                            <td class='td-pdf'>
                                {{
                                  GrupoPessoa::joins('grupo')
                                    ->whereRaw("LOWER(grupo.nome) = 'atualizado' AND grupo.id_empresa = ?", $person->id_empresa)
                                    ->where('pessoa_id', $person->id_pessoa)
                                    ->first()
                                    ->updated_at
                                    ->format('d/m/y')
                                }}
                            </td>
                            <td class='td-pdf'>{{ $person->codigo }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="page-break"></div>

        @if ($people['odd_people'])
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
                    @foreach ($people['odd_people'] as $person)
                        <tr>
                            <td class='td-pdf'>{{ $person->nome ? strtoupper($person->nome) : '' }}</td>
                            <td class='td-pdf'>{{ formated_endereco($person) }}</td>
                            <td class='td-pdf'>{{ $person->celular }} {{ $person->telefone }}</td>
                            <td class='td-pdf'>{{ $person->data_aniversario ? $person->data_aniversario->format('d/m/Y') : '' }}</td>
                            <td class='td-pdf'>
                                {{
                                  GrupoPessoa::joins('grupo')
                                    ->whereRaw("LOWER(grupo.nome) = 'atualizado' AND grupo.id_empresa = ?", $person->id_empresa)
                                    ->where('pessoa_id', $person->id_pessoa)
                                    ->first()
                                    ->updated_at
                                    ->format('d/m/y')
                                }}
                            </td>
                            <td class='td-pdf'>{{ $person->codigo }}</td>
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
