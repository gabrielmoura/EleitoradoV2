<div>
    <div class="row">
        <div class="col-md-2">
            <label>
                Selecione uma opção:
                <select wire:model="filter_by" class="form-control">
                    <option value="month">Mês</option>
                    <option value="week">Semana</option>
                    <option value="day">Dia</option>
                </select>
            </label>
        </div>
        <div class="col-md-2">
            <label>
                Data:
                <input type="date" wire:model="date" class="form-control"
                       data-date-language="pt-BR">
            </label>
        </div>
    </div>

    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Nascimento</th>
                <th>Contato</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nome</th>
                <th>Nascimento</th>
                <th>Contato</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($people as $birthday)
                <tr>
                    <td>{{ $birthday->name }}</td>
                    <td>{{ $birthday->dateOfBirth }}</td>
                    <td>{{ $birthday->cellphone }} @if($birthday->cellphone)
                            <a href="https://api.whatsapp.com/send?phone=55{{numberClear($birthday->cellphone)}}"
                               title="(Enviar mensagem no WhatsApp)"><i
                                    class="fab fa-whatsapp"></i></a>
                            <a href="https://t.me/+55{{numberClear($birthday->cellphone)}}"
                               title="(Enviar mensagem no Telegram)"><i
                                    class="fab fa-telegram"></i></a>
                        @endif</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
