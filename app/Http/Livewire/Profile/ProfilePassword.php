<?php

namespace App\Http\Livewire\Profile;

use App\Actions\Fortify\UpdateUserPassword;
use Livewire\Component;

class ProfilePassword extends Component
{
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function changePassword(UpdateUserPassword $updater)
    {
        $this->resetErrorBag();

        $updater->update(auth()->user(), $this->state);

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        session()->flash('status', 'Password successfully changed');
    }
    public function render()
    {
        return view('livewire.profile.profile-password');
    }
}
