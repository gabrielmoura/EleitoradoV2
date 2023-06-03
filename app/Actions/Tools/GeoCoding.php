<?php

namespace App\Actions\Tools;

use Geocoder\Collection;
use Geocoder\Provider\{ArcGISOnline\ArcGISOnline, Here\Here, Provider, TomTom\TomTom};
use Geocoder\Query\GeocodeQuery;
use Geocoder\StatefulGeocoder;
use Illuminate\Support\Facades\Cache;

class GeoCoding
{
    private $provider;

    public function setProvider($providerName = 'here')
    {
        $client = new \GuzzleHttp\Client();
        if ($providerName == 'here') {
            $this->limiter($providerName, Here::createUsingApiKey($client, config('geocoder.providers.here.token')));
        } elseif ($providerName == 'tomtom') {
            $this->limiter($providerName, new TomTom($client, config('geocoder.providers.tomtom.token')));
        } elseif ($providerName == 'arc') {
            $this->limiter($providerName, new ArcGISOnline($client, null, config('geocoder.providers.arcgis.token')));
        } else {
            throw new \Exception('Provider not defined');
        }
        return $this;
    }

    public function getCached(string $string): Collection
    {
        if ($this->provider === null) {
            throw new \Exception('Provider not defined');
        }
        $key = (strlen($string) <= 9) ? $string : md5($string);

        return Cache::remember('geocode:' . $key, config('geocoder.cache.duration', 6000), function () use ($string) {
            $geocoder = new StatefulGeocoder($this->provider);
            return $geocoder->geocodeQuery(GeocodeQuery::create($string));
        });
    }

    private function limiter(string $service, Provider $provider): void
    {
        Cache::increment('geocode:hint:' . $service);
        $times = (int)Cache::get('geocode:hit:' . $service);
        $hitBlock = $times >= config('geocoder.providers.' . $service . '.limit.times');
        //$lock = false;
        if ($hitBlock) {
            //  Obtem bloqueio quando numero de uso for maio ou igual ao limite.
            //$lock = !Cache::lock('foo', $this->timeLock($service))->get();
            Cache::set('geocode:lock:' . $service, true, $this->timeLock($service));
        }
        // Caso haja bloqueio de uso ou de tempo
        if ($hitBlock || Cache::has('geocode:lock:' . $service)) {
            Cache::delete('geocode:hint:' . $service);
            throw new \Exception('Limite de Api excedido:' . $service);
        }
        $this->provider = $provider;
    }

    private function timeLock(string $service): int|null
    {
        if (config('geocoder.providers.' . $service . '.limit.by') == 'm') {
            $time = now()->addMonth()->diffInSeconds();
        } elseif (config('geocoder.providers.' . $service . '.limit.by') == 'd') {
            $time = now()->addDay()->diffInSeconds();
        } elseif (config('geocoder.providers.' . $service . '.limit.by') == 'w') {
            $time = now()->addWeek()->diffInSeconds();
        } else {
            $time = null;
        }
        return $time;
    }
}
