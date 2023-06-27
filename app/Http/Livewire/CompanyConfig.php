<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CompanyConfig extends Component
{
    public $config;
    public $company;
    protected $listeners = ['refresh' => '$refresh'];

    public function mount(): void
    {
        $this->config = $this->company->config()->all();
    }

    public function store(): void
    {
        collect($this->config)->each(fn($value, $key) => $this->company->config()->set($key, $value));
        flash()->addSuccess('Configurações alteradas com sucesso.');
        $this->emit('refresh');
    }

    public function render(): Application|Factory|View
    {
        return view('livewire.company-config');
    }
}
