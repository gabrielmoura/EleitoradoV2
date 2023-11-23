<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Mapbox extends Component
{
    public float $centerLat = -43.22237791760682;

    public float $centerLong = -22.915969284544346;

    public ?float $lat;

    public ?float $long;

    public ?string $width = '20rem';

    public ?string $height = '20rem';

    public int $zoom = 9;

    public int $maxZoom = 19;

    public function render()
    {
        return view('livewire.mapbox');
    }
}
