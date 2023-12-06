<?php

namespace App\Service\Trait\Table;

trait WithFilter
{
    public array $filter = [];

    public function resetFilter(): void
    {
        $this->filter = [];
    }
}
