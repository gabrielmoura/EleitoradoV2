<?php

namespace App\Service\Trait\Table;

trait WithBulkActions
{
    public bool $bulkActionsEnabled = true;

    public bool $selectAll = false;

//    public array $bulkActions = [];

    public array $selected = [];

    //getSelected
    public function getSelected(): array
    {
        return $this->selected;
    }

    //clearSelected
    public function clearSelected(): void
    {
        $this->selected = [];
    }


    //setSelected
    public function setSelected(int|string $selected): void
    {
        if (in_array($selected, $this->selected)) {
            $this->selected = array_diff($this->selected, [$selected]);
        } else {
            $this->selected[] = $selected;
        }
    }

    //selectAll
    public function selectAll(): void
    {
        $this->selectAll = !$this->selectAll;
    }

    public function bulkActions(): array
    {
        if (property_exists($this, 'bulkActions')) {
            return $this->bulkActions;
        }

        return [];
    }

}
