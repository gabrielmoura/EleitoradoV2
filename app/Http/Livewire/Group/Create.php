<?php

namespace App\Http\Livewire\Group;

use Livewire\Component;

class Create extends Component
{
    public $name;

    public $description;

    protected $rules = [
        'name' => ['required', 'min:3', 'unique:groups,name'],
        'description' => ['nullable', 'min:3'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $validatedData = $this->validate();
        $validatedData['tenant_id'] = session()->get('tenant_id');
        $group = \App\Models\Group::create($validatedData);
        $this->emit('groupStored', $group->id);
        $this->reset();
        $this->emit('closeCreateModal');
        session()->flash('message', 'Group successfully created.');
    }

    public function render()
    {
        return view('livewire.group.create', [

        ]);
    }
}
