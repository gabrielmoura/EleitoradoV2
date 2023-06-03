<?php

namespace App\ServiceHttp;

class WeatherService
{
    public PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::withHeaders([
            'X-Rapidapi-Key'  => config('services.sport_score.key'),
            'X-Rapidapi-Host' => 'sportscore1.p.rapidapi.com',
        ])->baseUrl('https://sportscore1.p.rapidapi.com');
    }
}
