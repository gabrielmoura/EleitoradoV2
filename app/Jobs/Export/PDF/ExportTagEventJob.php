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
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

/**
 * @description Exporta Tags para serem coladas nos envelopes das cartas aos participantes de um determinado evento.
 */
class ExportTagEventJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $peerPage = 10;

    public Collection $data;

    public function __construct($data, public string $filename, public int $company_id, public string $tag_name, public ?string $type)
    {
        $this->data = collect($data);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function handle(): void
    {

        \PDF::reset();
        \PDF::SetTitle('Tags');
        foreach ($this->data->chunk($this->peerPage) as $datum) {
            $data = $datum;
            $tag_name = $this->tag_name;
            $view = \View::make($this->getView(), compact('data', 'tag_name'));
            $html = $view->render();

            \PDF::AddPage();
            \PDF::writeHTML($html, true, false, true, false, '');
        }
        $random = Str::random();
        $content = \PDF::Output('', 'S');
        $newName = "$this->filename-$this->tag_name-$random.pdf";

        \Storage::disk('public')->put($newName, $content);

        Company::find($this->company_id)
            ->addMedia(storage_path('app/public/' . $newName))
            ->withCustomProperties(['batchId' => $this->batch()->id])
            ->toMediaCollection('tag');
    }

    public function failed(Throwable $exception): void
    {
        report($exception);
    }

    private function getView(): string
    {
        if ($this->type === '1888') {
            return 'export.pdf.tag-1888';
        }
        return 'export.pdf.tag';
    }
}
