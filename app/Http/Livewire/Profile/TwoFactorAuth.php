<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Features;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;

class TwoFactorAuth extends Component
{
    use ConfirmsPasswords;

    public $showingConfirmation = false;

    public $showQrCode = false;

    public $showRecoveryCodes = false;

    public $code;

    public function enableTwoFactorAuth(EnableTwoFactorAuthentication $enable)
    {
        $enable(Auth::user());

        $this->showQrCode = true;
        $this->showRecoveryCodes = true;
        $this->showingConfirmation = true;
    }

    public function disableTwoFactorAuth(DisableTwoFactorAuthentication $disable)
    {
        $disable(Auth::user());
    }

    public function showRecoveryCodes()
    {
        $this->showRecoveryCodes = true;
    }

    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generate)
    {
        $generate(Auth::user());

        $this->showRecoveryCodes = true;
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function getEnabledProperty()
    {
        return ! empty($this->user->two_factor_secret);
    }

    public function confirmTwoFactorAuthentication(ConfirmTwoFactorAuthentication $confirm)
    {
        if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')) {
            $this->ensurePasswordIsConfirmed();
        }

        $confirm(Auth::user(), $this->code);

        $this->showQrCode = false;
        $this->showingConfirmation = false;
        $this->showRecoveryCodes = true;
    }

    public function render()
    {
        return view('livewire.profile.two-factor-auth');
    }
}
