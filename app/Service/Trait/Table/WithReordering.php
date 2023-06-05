<?php

namespace App\Service\Trait\Table;

trait WithReordering
{
    public string $defaultReorderColumn = 'created_at';

    public bool $defaultReorderDirection = true;

    public function orderBy($field): void
    {
        if ($this->defaultReorderColumn === $field) {
            $this->defaultReorderDirection = ! $this->defaultReorderDirection;
        } else {
            $this->defaultReorderDirection = true;
        }
        $this->defaultReorderColumn = $field;
    }
}
