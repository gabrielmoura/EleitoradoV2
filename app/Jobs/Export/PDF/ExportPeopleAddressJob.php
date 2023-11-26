<?php

namespace App\Jobs\Export\PDF;

use App\Models\Company;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Throwable;

/**
 * @description Exporta os endereços das pessoas em PDF, separando 10 pessoas por página.
 */
class ExportPeopleAddressJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $perPage = 10;

    public Collection $data;

    public function __construct(
        $data,
        public string $filename,
        public int $company_id,
        public string $group_by_name,
        public ?string $type = 'export.pdf.puxada-1',
        public ?string $district = null
    )
    {
        $this->data = collect($data);
    }

    public function handle(): void
    {

        $data = $this->data->groupBy('street')
            ->map(function ($street, $key) {
                return [
                    'name' => $key,
                    'even_address' => $street->filter(fn($person) => $person->number % 2 === 0)->map(function ($address) {
                        $love = $address->person;
                        $love->address = $address;
                        $love->checked_at = $address->person->groups->first()->pivot->checked_at;

                        return $love;
                    }),
                    'odd_address' => $street->filter(fn($person) => $person->number % 2 === 1)->map(function ($address) {
                        $love = $address->person;
                        $love->address = $address;
                        $love->checked_at = $address->person->groups->first()->pivot->checked_at;

                        return $love;
                    }),
                ];
            });
//        foreach ($data as $items) {
        $this->makePdf($data);
//        }
    }

    private function makePdf($data)
    {
        $html = View::make($this->type, [
            'streets' => $data,
            'group_name' => $this->group_by_name,
        ])->render();


//        $newName = $this->generateName($this->filename, $this->district ?? $this->group_by_name);

        $company = Company::find($this->company_id);
        $content = Browsershot::html($html)
            ->setNodeModulePath(base_path('node_modules'))
            ->setChromePath('/usr/bin/google-chrome-stable')
            ->newHeadless()
            ->noSandbox()
            ->showBackground()
            ->base64pdf();
        $this->updateMedia($company, $content);
    }

    private function updateMedia(Company $company, $content): void
    {
        try {
            $company->addMediaFromBase64($content)
                ->withCustomProperties([
                    'batchId' => $this->batch()->id,
                    'tenant_id' => $company->tenant_id,
                ])->toMediaCollection('puxada');

            DB::table('media')
                ->where('model_type', \App\Models\Company::class)
                ->where('model_id', $company->id)
                ->where('collection_name', 'puxada')
                ->update(['tenant_id' => $company->tenant_id]);

        } catch (\Throwable $throwable) {
            report($throwable);
        }
    }

    public function failed(Throwable $exception): void
    {
        report($exception);
    }

    private function generateName(string $filename, string $group_by_name): string
    {
        $random = Str::random(5);
        $filename = removeAccentsSpecialCharacters($filename);
        $group_by_name = removeAccentsSpecialCharacters($group_by_name);

        return "$filename-$group_by_name-$random.pdf";
    }
}
