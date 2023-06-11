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

    public function updateProfileInformation(UpdateUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(
            auth()->user(),
            $this->state
        );

        session()->flash('status', 'Profile successfully updated');
    }
    public function render()
    {
        return view('livewire.profile.profile-information');
    }
}
