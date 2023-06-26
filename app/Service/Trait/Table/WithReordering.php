<?php

namespace App\Service\Trait\Table;

trait WithReordering
{
    public string $defaultReorderColumn = 'created_at';

    public bool $defaultReorderASC = true;

    public function orderBy($field): void
    {
        if ($this->defaultReorderColumn === $field) {
            $this->defaultReorderASC = ! $this->defaultReorderASC;
        } else {
            $this->defaultReorderASC = true;
        }
        $this->defaultReorderColumn = $field;
    }
}
