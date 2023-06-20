<div class="card mb-4">
    <div class="card-header">Detalhes da conta</div>
    <div class="card-body">
        <form wire:submit.prevent="updateProfileInformation">
            <!-- Form Group (username)-->
            <div class="mb-3">
                <label class="small mb-1" for="name">Nome de usuário (como seu nome aparecerá para outros usuários no site)</label>
                <input class="form-control" id="name" type="text" placeholder="Enter your username" wire:model.defer="state.name" autocomplete="name">
                <x-input-error for="name" class="mt-2" />
            </div>
            <!-- Form Row-->
{{--            <div class="row gx-3 mb-3">--}}
{{--                <!-- Form Group (first name)-->--}}
{{--                <div class="col-md-6">--}}
{{--                    <label class="small mb-1" for="inputFirstName">First name</label>--}}
{{--                    <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" value="Valerie">--}}
{{--                </div>--}}
{{--                <!-- Form Group (last name)-->--}}
{{--                <div class="col-md-6">--}}
{{--                    <label class="small mb-1" for="inputLastName">Last name</label>--}}
{{--                    <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" value="Luna">--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- Form Row        -->
{{--            <div class="row gx-3 mb-3">--}}
{{--                <!-- Form Group (organization name)-->--}}
{{--                <div class="col-md-6">--}}
{{--                    <label class="small mb-1" for="inputOrgName">Organization name</label>--}}
{{--                    <input class="form-control" id="inputOrgName" type="text" placeholder="Enter your organization name" value="Start Bootstrap">--}}
{{--                </div>--}}
{{--                <!-- Form Group (location)-->--}}
{{--                <div class="col-md-6">--}}
{{--                    <label class="small mb-1" for="inputLocation">Location</label>--}}
{{--                    <input class="form-control" id="inputLocation" type="text" placeholder="Enter your location" value="San Francisco, CA">--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- Form Group (email address)-->
            <div class="mb-3">
                <label class="small mb-1" for="email">Email</label>
                <input class="form-control" id="email" type="email" placeholder="Enter your email address" wire:model.defer="state.email" autocomplete="email">
                <x-input-error for="email" class="mt-2" />
            </div>
            <!-- Form Row-->
            <div class="row gx-3 mb-3">
                <!-- Form Group (phone number)-->
                <div class="col-md-6">
                    <label class="small mb-1" for="phone">Número de celular</label>
                    <input class="form-control cel" id="phone" type="tel" placeholder="Enter your phone number" wire:model.defer="state.phone" autocomplete="phone">
                    <x-input-error for="phone" class="mt-2" />

                </div>
                <!-- Form Group (birthday)-->
                <div class="col-md-6">
                    <label class="small mb-1" for="inputBirthday">Data de Nascimento</label>
                    <input class="form-control" id="inputBirthday" type="date" name="birthday" placeholder="Enter your birthday" wire:model.defer="state.birthday" autocomplete="birthday">
                    <x-input-error for="birthday" class="mt-2" />
                </div>
            </div>
            <!-- Save changes button-->
            <button class="btn btn-primary" type="submit">Save changes</button>
            <x-action-message class="mr-3" on="saved">
                Save
            </x-action-message>
        </form>
    </div>
</div>
