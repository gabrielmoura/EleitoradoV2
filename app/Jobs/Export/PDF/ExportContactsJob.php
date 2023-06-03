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

/**
 * @description Exporta os contatos em PDF, separando 10 contatos por página.
 */
class ExportContactsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $peerPage = 10;
    public Collection $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data, public string $filename, public int $company_id, public string $group_by_name)
    {
        $this->data = collect($data);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \PDF::reset();
        \PDF::SetTitle('Lista de Contatos');
        foreach ($this->data->chunk($this->peerPage) as $data) {
            $group_name = $this->group_by_name;
            $view = \View::make('export.pdf.contact-list', compact('data', 'group_name'));
            $html = $view->render();

            \PDF::AddPage();
            \PDF::writeHTML($html, true, false, true, false, '');
        }
        $random = Str::random();
        $content = \PDF::Output('', 'S');
        $newName = "$this->filename-$this->group_by_name-$random.pdf";

        \Storage::disk('public')->put($newName, $content);

        Company::find($this->company_id)
            ->addMedia(storage_path('app/public/' . $newName))
            ->withCustomProperties(['batchId' => $this->batch()->id])
            ->toMediaCollection('contactList');
    }
}
