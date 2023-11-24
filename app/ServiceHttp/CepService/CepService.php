<?php

namespace App\ServiceHttp\CepService;

use App\Actions\Tools\RedisHash\RedisHash;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class CepService
{
    public PendingRequest $api;

    private mixed $data;

    public function __construct()
    {
        $this->api = Http::acceptJson()
            ->contentType('application/json')
            ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36');
        $this->redis = new RedisHash();
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
                $this->redis->rememberArray("cep:$cep", function () use ($cep) {
                    return $this->getCep($cep)->collect()->toArray();
                }, 60 * 60 * 24)
            );
        }

        return new Cep($this->getCep($cep)->collect()->toArray());
    }
}
