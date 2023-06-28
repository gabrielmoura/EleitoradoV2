<?php

namespace App\Actions\Tools;

use App\Models\Company;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CompanyConfig
{
    private Collection $config;

    public function __construct(private readonly Company $company)
    {
        $this->config = $this->company->conf;
    }

    public function all(bool $dot = false): Collection
    {
        if ($dot) {
            return collect(Arr::dot($this->config->toArray()));
        }

        return $this->config;
    }

    public function get(string $key): mixed
    {
        $data = Arr::dot($this->config->toArray());

        return $data[$key] ?? null;
    }

    public function set(string $key, mixed $value): void
    {
        $data = Arr::dot($this->config->toArray());
        $data[$key] = $value;

        $this->company->conf = Arr::undot($data);
        $this->company->save();
    }

    public function has(string $key): bool
    {
        $data = Arr::dot($this->config->toArray());

        return Arr::has($data, $key);
    }

    public function setDefault(): void
    {
        $this->company->conf = $this->default();
        $this->company->save();
    }

    protected function default(): Collection
    {
        return collect([
            'utalk' => [
                'key' => null,
                'phone' => null,
                'organization_id' => null,
            ],
            'telegram' => [
                'key' => null,
                'name' => null,
            ],
            'send_birthday' => [
                'mail' => false,
                'whatsapp' => false,
            ],
        ]);
    }
}
