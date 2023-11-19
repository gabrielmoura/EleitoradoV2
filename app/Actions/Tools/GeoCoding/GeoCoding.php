<?php

namespace App\Actions\Tools\GeoCoding;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoCoding
{
    private PendingRequest $http;
    private PromiseInterface|Response $response;

    public function __construct()
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36';
        $this->http = Http::withUserAgent($userAgent)->acceptJson();
    }


    public function getCached(?string $street, ?string $district, ?string $city, ?string $state, ?string $country, ?string $postal_code): Collection
    {
        $key = $this->generateCacheKey($street, $district, $postal_code);
        $string = $this->generateString($street, $district, $city, $state, $country, $postal_code);

        if (!Cache::has('geocode:' . $key)) {
            $this->geocodeAddress($string);
            $response = $this->response->json();
            // Verifica a resposta e caso seja nula, retorna um array vazio
            Cache::set('geocode:' . $key, $response, 60 * 60 * 24 * 30); // 30 dias
            if (empty($response)) {
                return collect();
            }
            return $this->transformResponse($response);
        } else {
            // Caso exista, retorna o cache
            $response = Cache::get('geocode:' . $key);
            return $this->transformResponse($response);
        }
    }

    private function transformResponse(array $response): Collection
    {
        return collect($response)->map(function ($item) {
            return new LocationDTO(
                place_id: $item['place_id'],
                licence: $item['licence'],
                osm_type: $item['osm_type'],
                osm_id: $item['osm_id'],
                lat: $item['lat'],
                lon: $item['lon'],
                category: $item['category'] ?? null,
                type: $item['type'],
                place_rank: $item['place_rank'],
                importance: $item['importance'],
                addresstype: $item['addresstype'],
                name: $item['name'],
                display_name: $item['display_name'],
                boundingbox: $item['boundingbox'],
                geojson: $item['geojson'] ?? null,
                postal_code: null,
                street: null,
                district: null
            );
        });
    }


    private function geocodeAddress(string $string): void
    {
        $enderecoFormatado = str_replace(' ', '+', $string);

        $url = "https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&q={$enderecoFormatado}";

        Cache::lock('lock:geocode', 1)->get(function () use ($url) {
            $this->response = $this->http->get($url);
        });
    }

    private function generateCacheKey(?string $street, ?string $district, ?string $postal_code): string
    {
        return $postal_code ?? "$district:$street";
    }

    private function generateString(?string $street, ?string $district, ?string $city, ?string $state, ?string $country, ?string $postal_code): string
    {
        return $postal_code ?? implode(',', array_filter([$street, $district, $city, $state, $country]));
    }

}
