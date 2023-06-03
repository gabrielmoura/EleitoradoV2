<?php

namespace App\Actions\Export\Pdf;

use App\Actions\DB\SQuery;
use App\Models\Company;
use App\Traits\CompanySessionTrait;
use Barryvdh\DomPDF\Facade\Pdf;

class Puxada
{
    use CompanySessionTrait;

    public function me($group_name = 'ATUALIZADO')
    {
        $query = new SQuery();
        $data = $query->Puxada($group_name);

        // A pasta seguir tem pouco tempo de duração.
        $filename = now()->toDateString() . '-' . \Str::random(5) . '.pdf';
        $path = temp_path($filename);

        $pdf = Pdf::loadView('export.pdf.puxada', compact('data', 'group_name'));
        file_put_contents($path, $pdf->output());

        $this->getCompany()->addMedia($path)
            ->toMediaCollection('puxada'); // Add Media Collection com tempo de expiração
        return $this->getCompany()->getMedia('puxada');

    }
}
