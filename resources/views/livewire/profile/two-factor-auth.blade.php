<div class="card mb-4">
    <div class="card-header">Autenticação de dois fatores</div>
    <div class="card-body">
        <h3 class="text-lg font-medium text-gray-900">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Finish enabling two factor authentication.') }}
                @else
                    {{ __('You have enabled two factor authentication.') }}
                @endif
            @else
                {{ __('You have not enabled two factor authentication.') }}
            @endif
        </h3>
        <p>
            {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
        </p>

        @if ($this->enabled)
            @if ($showQrCode)
                <p class="fw-600">
                    @if ($showingConfirmation)
                        {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                    @else
                        {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.') }}
                    @endif
                </p>

                <div>
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <p class="fw-600 shadow-left-sm">
                    {{ __('Setup Key') }}: {{ decrypt($this->user->two_factor_secret) }}
                </p>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('Code') }}"/>

                        <x-input id="code" type="text" name="code" class="block mt-1 w-1/2" inputmode="numeric"
                                 autofocus autocomplete="one-time-code"
                                 wire:model.defer="code"
                                 wire:keydown.enter="confirmTwoFactorAuthentication"/>

                        <x-input-error for="code" class="mt-2"/>

                            <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                                <x-button type="button" class="btn " wire:loading.attr="disabled">
                                    {{ __('Confirm') }}
                                </x-button>
                            </x-confirms-password>

                    </div>
                @endif
            @endif

            @if ($showRecoveryCodes)
                <div class="mt-4">
                    <p>
                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                    </p>

                    <div class="code shadow-left-sm">
                        @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                            <code>{{ $code }}</code>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="mt-4">
                @if ($showRecoveryCodes)
                    <button wire:click="
                            regenerateRecoveryCodes" class="btn btn-secondary">
                        Regenerate Recovery Codes
                    </button>

                @else
                    <button wire:click="
                            showRecoveryCodes" class="btn btn-secondary">
                        Show Recovery Codes
                    </button>
                @endif



                <button wire:click="
                            disableTwoFactorAuth" class="btn btn-primary">
                    Disable Two-Factor Authentication
                </button>
            </div>

        @else
            <button wire:click="enableTwoFactorAuth" class="btn btn-black">
                {{ __('Enable') }}
            </button>
    </div>

    @endif

</div>
