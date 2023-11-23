<?php

namespace App\Actions\Tools\GeoCoding;

class LocationDTO
{
    public function __construct(
        public int $place_id,
        public string $licence,
        public string $osm_type,
        public int $osm_id,
        public string $lat,
        public string $lon,
        public ?string $category,
        public string $type,
        public int $place_rank,
        public float $importance,
        public string $addresstype,
        public string $name,
        public string $display_name,
        public array $boundingbox,
        public ?array $geojson,
        public ?string $postal_code,
        public ?string $street,
        public ?string $district
    ) {
        // Extrair o código postal usando a expressão regular
        if (preg_match('/([0-9]{5}-?[0-9]{3})/', $display_name, $matches)) {
            $this->postal_code = $matches[1];
        }

        $splitAddress = preg_split('/,\s*/', $display_name);
        $this->street = $splitAddress[0] ?? null;
        $this->district = $splitAddress[1] ?? null;
    }

    //$chaves = array(
    //'Rua',
    //'Bairro',
    //'Cidade',
    //'Regiao Geografica Imediata',
    //'Regiao Metropolitana',
    //'Regiao Geografica Intermediaria',
    //'Estado',
    //'Regiao',
    //'CEP',
    //'Pais'
    //);

}
