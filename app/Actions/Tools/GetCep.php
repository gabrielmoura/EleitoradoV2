<?php

namespace App\Actions\Tools;

use App\Exceptions\GetCepException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetCep
{
    private PendingRequest $api;

    private array $data;

    private int $time;

    private int $code;

    public function __construct(
        int $time = 600,
        string $baseUrl = 'https://viacep.com.br/ws/',
        private readonly string $suffix = '/json/')
    {
        $this->api = Http::acceptJson()->baseUrl($baseUrl);
        $this->time = $time;
    }

    /**
     * @throws GetCepException
     */
    public static function find(string $cep): static
    {
        return (new self())->getZipCode(numberClear($cep));
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return $this
     *
     * @throws GetCepException
     */
    public function getZipCode($zipCode): static
    {
        if ($zipCode == null) {
            throw new GetCepException('CEP is null', 400);
        }
        if (strlen($zipCode) != 8) {
            throw new GetCepException('CEP is not 8 digits', 400);
        }

        $req = $this->api->get(url: $zipCode.$this->suffix);
        if ($req->failed()) {
            throw new GetCepException('CEP not found', 404);
        }
        $this->data = $req->json();
        $this->code = (int) $zipCode;

        return $this;
    }

    /**
     * @throws GetCepException
     */
    public function getCached(): array
    {
        if ($this->code == null) {
            throw new GetCepException('CEP Não definido', 400);
        }
        if (! is_numeric($this->code)) {
            throw new GetCepException('CEP Não é numérico', 400);
        }

        return Cache::remember('Postal:'.$this->code, $this->time, fn () => $this->data);
    }
}
