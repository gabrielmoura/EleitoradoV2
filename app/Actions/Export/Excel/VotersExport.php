<?php

namespace App\Actions\Export\Excel;

use App\Models\Voter;

class VotersExport implements \Maatwebsite\Excel\Concerns\FromCollection
{

    public $voters;

    public function __construct($voters) {
        $this->voters = $voters;
    }

    public function collection()
    {
        return Voter::whereIn('id', $this->voters)->get();
    }
}
