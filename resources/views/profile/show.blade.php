<x-app-layout>
    {{--    <x-slot name="header">--}}
    {{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
    {{--            {{ __('Profile') }}--}}
    {{--        </h2>--}}
    {{--    </x-slot>--}}

    {{--    <div>--}}
    {{--        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">--}}
    {{--            @if (Laravel\Fortify\Features::canUpdateProfileInformation())--}}
    {{--                @livewire('profile.update-profile-information-form')--}}

    {{--                <x-section-border />--}}
    {{--            @endif--}}

    {{--            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))--}}
    {{--                <div class="mt-10 sm:mt-0">--}}
    {{--                    @livewire('profile.update-password-form')--}}
    {{--                </div>--}}

    {{--                <x-section-border />--}}
    {{--            @endif--}}

    {{--            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())--}}
    {{--                <div class="mt-10 sm:mt-0">--}}
    {{--                    @livewire('profile.two-factor-authentication-form')--}}
    {{--                </div>--}}

    {{--                <x-section-border />--}}
    {{--            @endif--}}

    {{--            <div class="mt-10 sm:mt-0">--}}
    {{--                @livewire('profile.logout-other-browser-sessions-form')--}}
    {{--            </div>--}}

    {{--            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())--}}
    {{--                <x-section-border />--}}

    {{--                <div class="mt-10 sm:mt-0">--}}
    {{--                    @livewire('profile.delete-user-form')--}}
    {{--                </div>--}}
    {{--            @endif--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        Configurações da conta
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="container-xl px-4 mt-4" x-data="{partial:'info'}">
        <nav class="nav nav-borders">
            <a x-bind:class="partial==='info' ? 'nav-link active ms-0' : 'nav-link'" href="#" @click="partial = 'info'">Perfil</a>
            <a x-bind:class="partial==='billing' ? 'nav-link active ms-0' : 'nav-link'" href="#">Pagamentos</a>
            <a x-bind:class="partial==='security' ? 'nav-link active ms-0' : 'nav-link'" href="#"
               @click="partial = 'security'">Segurança</a>
            <a x-bind:class="partial==='notification' ? 'nav-link active ms-0' : 'nav-link'" href="#"
               @click="partial = 'notification'">Notificações</a>
        </nav>
        <hr class="mt-0 mb-4">

        <div class="row" x-show="partial==='info'" x-transition>
            <div class="col-xl-4">
                <livewire:profile.profile-avatar/>
            </div>
            <div class="col-xl-8">
                <livewire:profile.profile-information/>
            </div>
        </div>

        <div class="row" x-show="partial==='notification'" x-transition>
            <div class="col-xl-8">
                <livewire:profile.profile-notification-preferences/>
            </div>
            <div class="col-xl-4">
            </div>
        </div>

        <div class="row" x-show="partial==='security'" x-transition>
            <div class="col-xl-8">
                <livewire:profile.profile-password/>
                <livewire:profile.other-browsers/>
            </div>
            <div class="col-xl-4">
                <livewire:profile.two-factor-auth/>
            </div>
        </div>

    </div>
</x-app-layout>
