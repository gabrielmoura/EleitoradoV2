<?php

namespace App\Http\Livewire\Profile;

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
        'upload:errored' => 'updateError'
    ];

    public function updatePhoto(): void
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        $this->user->updateProfilePhoto($this->photo);
        flash()->addSuccess('Profile photo updated successfully');
    }

    public function updateError($name = null): void
    {
        flash()->addError('Profile photo update failed' . $name);
    }

    public function render()
    {
        return view('livewire.profile.profile-avatar');
    }
}
