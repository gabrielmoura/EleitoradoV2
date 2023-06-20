<?php

namespace App\Http\Livewire\Profile;

use App\Actions\Fortify\UpdateUserProfileInformation;
use Livewire\Component;

class ProfileInformation extends Component
{
    public $state = [];

    public function mount()
    {
        $this->state = auth()->user()->withoutRelations()->toArray();
    }

    public function updateProfileInformation(UpdateUserProfileInformation $updater): void
    {
        $this->resetErrorBag();

        $updater->update(
            auth()->user(),
            $this->state
        );

        flash()->addSuccess('Perfil atualizado com sucesso');
    }

    public function render()
    {
        return view('livewire.profile.profile-information');
    }
}
