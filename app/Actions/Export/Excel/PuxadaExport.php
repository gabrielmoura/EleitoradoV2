<?php

namespace App\Actions\Export\Excel;

use App\Models\Voter;

class PuxadaExport implements \Maatwebsite\Excel\Concerns\FromCollection
{

    public $voters;

    public function __construct($voters) {
        $this->voters = $voters;
    }

    public function collection()
    {
        return $this->voters;
    }
}
