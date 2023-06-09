<?php

namespace App\ServiceHttp\CepService;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CepService
{
    public PendingRequest $api;

    private mixed $data;

    public function __construct()
    {
        $this->api = Http::acceptJson()
            ->contentType('application/json');
    }

    private function getCep(string $cep)
    {
        return $this->api->get("https://viacep.com.br/ws/$cep/json");

    }

    public static function find(string $cep, bool $cached = true): Cep
    {
        return (new self())->get($cep, $cached);
    }

    public function get(string $cep, bool $cached = true): Cep
    {
        if ($cached) {
            return new Cep(
                Cache::remember("cep:$cep", 600, function () use ($cep) {
                    return $this->getCep($cep)->collect()->toArray();
                })
            );
        }

        return new Cep($this->getCep($cep)->collect()->toArray());
    }
}
