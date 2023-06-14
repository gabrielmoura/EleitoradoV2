<?php

namespace App\Http\Livewire;

use App\Models\Person;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Birthdays extends Component
{
    public $filter_by = 'month';

    public Carbon $date_reference;

    public string $date;

    private Person $person;

    public function mount(Person $person): void
    {
        $this->person = $person;
        $this->date_reference = now();
    }

    public function render()
    {
        if (! empty($this->date)) {
            $this->date_reference = Carbon::parse($this->date);
        }

        $query = $this->person;
        if ($this->filter_by == 'month') {
            $query = $query->whereMonth('dateOfBirth', $this->date_reference->month);
        } elseif ($this->filter_by == 'week') {
            $query = $query->whereBetween('dateOfBirth', [$this->date_reference->startOfWeek(), $this->date_reference->endOfWeek()]);
        } elseif ($this->filter_by == 'day') {
            $query = $query->whereDay('dateOfBirth', $this->date_reference->day);
        }
        $people = $query->get();

        return view('livewire.birthdays', compact('people'));
    }
}
