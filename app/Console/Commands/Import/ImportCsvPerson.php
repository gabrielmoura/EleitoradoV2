<?php

namespace App\Console\Commands\Import;

use App\Models\Address;
use App\Models\Company;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\LazyCollection;

class ImportCsvPerson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv-person
                            {company : The ID of the company}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //0"id_pessoa",1"nome",2"logradouro",3"numero",4"complemento",5"bairro",6"cidade",7"uf",8"cep",9"data_aniversario",10"telefone",
        //11"celular",12"cpf",13"email",14"anotacoes",15"id_empresa",16"created_at",17"updated_at",18"foto_file_name",19"foto_content_type",
        //20"foto_file_size",21"foto_updated_at",22"facebook",23"twitter",24"google_plus",25"instagram",26"linkedin",27"identidade",28"ativo",
        //29"sexo",30"chaveouvinte",31"id_source_clone",32"is_guest",33"zona",34"secao",35"titulo",36"data_notificacao",37"imprimir_placa",38"profissao"
        $this->info('Inicio da importação.');
        $start = now();
        $company_id = $this->argument('company');

        $tenant_id = Company::find($company_id)->tenant_id;
        $times = 20;

        $this->importData($tenant_id, $times);

        $time = now()->diffInSeconds($start);
        $this->info("Fim da importação. Tempo: $time segundos");
    }

    private function importData(int $tenant_id, int $chunkSize)
    {
        $path = (string) storage_path($this->ask('Qual o caminho do arquivo?ex: app/imports/2021-01-01.csv'));
        $handle = fopen($path, 'r');

        LazyCollection::make(function () use ($handle) {
            while (($line = fgets($handle)) !== false) {
                yield str_getcsv($line, ',');
            }
        })->filter()->skip(1)->chunk($chunkSize)->each(function ($chunk) use ($tenant_id) {
            $this->processChunk($chunk, $tenant_id);
        });

        fclose($handle);
    }

    private function processChunk(array $chunk, int $tenant_id)
    {
        foreach ($chunk as $item) {
            $name = data_get($item, '1');
            if ($name !== null) {
                $person = Person::create([
                    'tenant_id' => $tenant_id,
                    'name' => $item[1],
                    'email' => $item[13] ?? null,
                    'cellphone' => $item[11] ?? null,
                    'dateOfBirth' => $this->val($item, 9, 'date'),
                    'cpf' => $item[12] ?? null,
                    'telephone' => $item[10] ?? null,
                    'voter_zone' => $item[33] ?? null,
                    'voter_section' => $item[34] ?? null,
                    'voter_registration' => $item[35] ?? null,
                    'sex' => $this->val($item, 29, 'sex'),
                ]);

                $address = Address::create([
                    'street' => $item[2] ?? null,
                    'number' => $this->val($item, 3, 'int', 9),
                    'complement' => $item[4] ?? null,
                    'district' => $item[5] ?? null,
                    'city' => $item[6] ?? null,
                    'state' => $this->val($item, 7, 'int', 2),
                    'country' => 'BR',
                    'zipcode' => $this->val($item, 8, 'int', 9),
                    'tenant_id' => $tenant_id,
                    'uf' => $this->val($item, 7, 'int', 2),
                ]);

                $person->address()->associate($address->id);
            }
        }
    }

    private function val(array $item, int $index, string $type = 'string', int $max = null): mixed
    {
        if (! array_key_exists($index, $item) || strlen(trim($item[$index])) === 0) {
            return null;
        }

        $data = trim($item[$index]);

        if ($type === 'int') {
            return (strlen($data) < $max) ? intval(numberClear($data)) : null;
        }

        if ($type === 'float') {
            return floatval($data);
        }

        if ($type === 'date' && preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $data)) {
            return Carbon::parse($data);
        }

        if ($type === 'sex') {
            return ($data === 'N') ? null : $data;
        }

        return (strlen($data) <= $max) ? $data : null;
    }
}
