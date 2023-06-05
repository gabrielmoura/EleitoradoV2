<?php

namespace App\Actions\Export\Excel;

class PuxadaExport implements \Maatwebsite\Excel\Concerns\FromCollection
{
    public $voters;

    public function __construct($voters)
    {
        $this->voters = $voters;
    }

    public function collection()
    {
        return $this->voters;
    }
}
