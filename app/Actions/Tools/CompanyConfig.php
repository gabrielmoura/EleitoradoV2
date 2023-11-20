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

    /**
     * @description Retorna todas as configurações da empresa
     * @param bool $dot
     * @return Collection
     */
    public function all(bool $dot = false): Collection
    {
        if ($dot) {
            return collect(Arr::dot($this->config->toArray()));
        }

        return $this->config;
    }

    /**
     * @description Retorna o valor da configuração
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        $data = Arr::dot($this->config->toArray());

        return $data[$key] ?? null;
    }

    /**
     * @description Altera o valor da configuração
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $data = Arr::dot($this->config->toArray());
        $data[$key] = $value;

        $this->company->conf = Arr::undot($data);
        $this->company->save();
    }

    /**
     * @description Verifica se a configuração existe
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        $data = Arr::dot($this->config->toArray());

        return Arr::has($data, $key);
    }

    /**
     * @description Remove todas as configurações da empresa
     * @return void
     */
    public function setDefault(): void
    {
        $this->company->conf = self::default();
        $this->company->save();
    }

    /**
     * @description Retorna os nomes das configurações
     * @return string[]
     */
    public static function getNames(): array
    {
        return [
            'utalk.key' => 'Chave Utalk',
            'utalk.phone' => 'Telefone Utalk',
            'utalk.organization_id' => 'ID da organização Utalk',
            'telegram.key' => 'Chave do bot Telegram',
            'telegram.name' => 'Nome do bot Telegram',
            'send_birthday.mail' => 'Enviar email de aniversário',
            'send_birthday.whatsapp' => 'Enviar whatsapp de aniversário',
        ];
    }

    /**
     * @description Retorna as configurações padrões
     * @return array
     */
    public static function default(): array
    {
        return [
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
        ];
    }
}
