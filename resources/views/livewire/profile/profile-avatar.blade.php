<div class="card mb-4 mb-xl-0">
    <div class="card-header">Profile Picture</div>
    <div class="card-body text-center" x-data="{photoName: null,photoPreview:null}">
        <!-- Profile Photo File Input -->
        <input type="file" class="d-none"
               wire:model="photo"
               x-ref="photo"
               x-on:change="photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            "/>

{{--        <x-label for="photo" value="{{ __('Photo') }}"/>--}}
        <!-- Profile picture image-->

            <img class="img-account-profile rounded-circle mb-2"
                 src="{{ $user->profile_photo_url }}"
                 x-bind:src="photoPreview==null ? '{{ $user->profile_photo_url }}' : photoPreview"
                 alt="{{ $user->name }}"/>

        <div class="small font-italic text-muted mb-4"> JPG ou PNG não maior que 5 MB</div>

        <button class="btn btn-primary" type="button" x-on:click.prevent="$refs.photo.click()">Upload new image</button>
        @if ($user->profile_photo_path)
            <button type="button" class="btn btn-secondary" wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </button>
        @endif
    </div>
</div>

