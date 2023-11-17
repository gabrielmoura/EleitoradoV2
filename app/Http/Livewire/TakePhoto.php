<?php

namespace App\Http\Livewire;

use Intervention\Image\Facades\Image;
use Livewire\Component;

class TakePhoto extends Component
{
    protected $listeners = ['fileUpload' => 'handleFileUpload'];
    public string $width = '640', $height = '480';

    public function render()
    {
        return view('livewire.take-photo');
    }

    public function handleFileUpload(string $photoData): void
    {
        try {
            $path = sys_get_temp_dir() . '/photo/' . now()->timestamp . '.jpg';
            Image::make($photoData)->save($path);
            $this->emitUp('photoUploaded', $path);
        } catch (\Exception $e) {
            $this->emitUp('photoUploadError', $e->getMessage());
            return;
        }
    }
}
