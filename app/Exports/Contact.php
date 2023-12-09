<?php

namespace App\Exports;

use App\Models\Person;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class Contact implements FromCollection
{
    /**
     * @param  Collection  $collection <\App\Models\Person>
     */
    public function __construct(public Collection $collection)
    {
    }

    public function collection(): Collection
    {
        return $this->collection->map(function (Person $item) {
            return [
                'ID' => $item->pid,
                'Nome' => $item->name,
                'Data de Nascimento' => $item?->birth_date,
                'Telefone' => $item?->telephone?->toE164(),
                'Celular' => $item?->cellphone?->toE164(),
                'Logradouro' => $item?->address?->street,
                'Número' => $item?->address?->number,
                'Complemento' => $item?->address?->complement,
                'Bairro' => $item?->address?->district,
                'Atualizado em' => $item->updated_at,
            ];
        });
    }
}
