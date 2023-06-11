<div class="card mb-4">
    <div class="card-header">Alterar a senha</div>
    <div class="card-body">
        <form wire:submit.prevent="changePassword">
            <!-- Form Group (current password)-->
            <div class="mb-3">
                <label class="small mb-1" for="current_password">Current Password</label>
                <input class="form-control" id="current_password" type="password" placeholder="Enter current password"
                       wire:model.defer="state.current_password" autocomplete="current-password">
                <x-input-error for="current_password" class="mt-2"/>
            </div>
            <!-- Form Group (new password)-->
            <div class="mb-3">
                <label class="small mb-1" for="password">New Password</label>
                <input class="form-control" id="password" type="password" placeholder="Enter new password"
                       wire:model.defer="state.password" autocomplete="new-password">
                <x-input-error for="password" class="mt-2"/>
            </div>
            <!-- Form Group (confirm password)-->
            <div class="mb-3">
                <label class="small mb-1" for="password_confirmation">Confirm Password</label>
                <input class="form-control" id="password_confirmation" type="password"
                       placeholder="Confirm new password" wire:model.defer="state.password_confirmation"
                       autocomplete="new-password">
                <x-input-error for="password_confirmation" class="mt-2"/>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
</div>
