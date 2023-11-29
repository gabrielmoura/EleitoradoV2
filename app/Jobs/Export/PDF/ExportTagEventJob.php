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
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Throwable;

/**
 * @description Exporta Tags para serem coladas nos envelopes das cartas aos participantes de um determinado evento.
 */
class ExportTagEventJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Collection $data;

    /**
     * ExportTagEventJob constructor.
     */
    public function __construct($data, public string $filename, public int $company_id, public string $tag_name, public ?string $type)
    {
        $this->data = collect($data);
    }

    /**
     * @description Executa o job
     */
    public function handle(): void
    {
        $this->makePdf($this->data);
    }

    /**
     * @description Executa quando o job falha
     */
    public function failed(Throwable $exception): void
    {
        report($exception);
    }

    /**
     * @description Retorna a view que será renderizada
     */
    private function getView(): string
    {
        if ($this->type === '1888') {
            return 'export.pdf.tag-1888';
        }

        return 'export.pdf.tag-1';
    }

    /**
     * @description Gera o nome do arquivo
     */
    private function generateName(string $filename, string $tag_name): string
    {
        $random = Str::random(5);
        $filename = removeAccentsSpecialCharacters($filename);
        $tag_name = removeAccentsSpecialCharacters($tag_name);

        return "$filename-$tag_name-$random.pdf";
    }

    /**
     * @description Gera o PDF
     */
    private function makePdf($data): void
    {
        $html = View::make($this->getView(), [
            'data' => $data,
            'tag_name' => $this->tag_name,
        ])->render();

        $company = Company::find($this->company_id);
        // define A4
        $content = Browsershot::html($html)
            ->setNodeModulePath(base_path('node_modules'))
            ->setChromePath('/usr/bin/google-chrome-stable')
            ->newHeadless()
            ->noSandbox()
            ->format('A4')
            ->margins(0, 0, 0, 0)
            ->showBackground()
            ->base64pdf();
        $this->updateMedia($company, 'tag', $content);
    }

    /**
     * @description Atualiza o media do company
     */
    private function updateMedia(Company $company, string $collection_name, $content): void
    {
        try {
            $company->addMediaFromBase64($content)
                ->usingFileName(
                    $this->generateName($this->filename, $this->tag_name)
                )->withCustomProperties([
                    'batchId' => $this->batch()->id,
                    'tenant_id' => $company->tenant_id,
                ])->toMediaCollection($collection_name);

            DB::table('media')
                ->where('model_type', \App\Models\Company::class)
                ->where('model_id', $company->id)
                ->where('collection_name', $collection_name)
                ->update(['tenant_id' => $company->tenant_id]);

        } catch (\Throwable $throwable) {
            report($throwable);
        }
    }
}
