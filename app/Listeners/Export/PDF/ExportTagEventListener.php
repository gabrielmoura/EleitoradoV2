<?php

namespace App\Listeners\Export\PDF;

use App\Events\Export\PDF\RequestExportTagEvent;
use App\Jobs\Export\PDF\ExportTagEventJob;
use App\Models\Event;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class ExportTagEventListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * @throws Throwable
     */
    public function handle(RequestExportTagEvent $event): void
    {
        $batch = Bus::batch([])->then(function (Batch $batch) {
            // Event for Success
        })->catch(function (Batch $batch, Throwable $e) {
            // Event for Failed
        })->name('Export People Address')->dispatch();

        Event::find($event->event_id)->persons()->with('address')->get()->chunk(100)->each(function ($item) use (&$batch, &$event) {
            $batch->add(new ExportTagEventJob(
                data: $item,
                filename: 'tag-'.$event->event_id,
                company_id: $event->company_id,
                tag_name: 'tag-'.$event->event_id,
            ));
        });
    }
}
