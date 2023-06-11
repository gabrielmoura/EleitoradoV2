<?php

namespace App\Http\Livewire\Profile;

use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Validation\Rules\Password;
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
        $this->validate([
            'state.current_password' => ['required', 'password'],
            'state.password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);
        $this->resetErrorBag();

        $updater->update(auth()->user(), $this->state);

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];
        flash()->addSuccess('Senha alterada com sucesso');

    }

    public function render()
    {
        return view('livewire.profile.profile-password');
    }
}
