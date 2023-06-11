<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileAvatar extends Component
{
    use WithFileUploads;

    public $photo;
    public $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    protected $listeners = [
        'upload:finished' => 'updatePhoto',
        'upload:errored' => 'updatedError'
    ];

    public function updatePhoto(): void
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        $this->user->updateProfilePhoto($this->photo);
        session()->put('user.profile_photo_url', $this->user->profile_photo_url);
        flash()->addSuccess('Profile photo updated successfully');
    }

    public function updatedError($name = null): void
    {
        flash()->addError('Profile photo update failed' . $name);
    }

    public function deleteProfilePhoto(): void
    {
        $this->user->deleteProfilePhoto();
        session()->put('user.profile_photo_url', $this->user->profile_photo_url);
        flash()->addSuccess('Profile photo deleted successfully');
    }

    public function render(): Application|Factory|View
    {
        return view('livewire.profile.profile-avatar');
    }
}
