<?php

namespace App\Service\Trait\Table;

trait WithColumnSelect
{
    public array $selectedColumns = [];

    //selectAllColumns
    public function selectAllColumns(): void
    {
        $this->selectedColumns = array_keys($this->columns);
    }

    //deselectAllColumns
    public function deselectAllColumns(): void
    {
        $this->selectedColumns = [];
    }

    //updatedSelectedColumns
    public function updatedSelectedColumns(): void
    {
        $this->selectedColumns = array_values($this->selectedColumns);
    }

    public function getDefaultVisibleColumns(): array
    {
        return collect($this->getColumns())
            ->filter(function ($column) {
                return $column->isVisible() && $column->isSelectable() && $column->isSelected();
            })
            ->map(fn ($column) => $column->getSlug())
            ->values()
            ->toArray();
    }
}
