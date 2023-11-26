<?php

namespace App\Listeners\Export\PDF;

use App\Events\Export\PDF\ExportedPeopleAddress;
use App\Events\Export\PDF\FailedExportPeopleAddress;
use App\Events\Export\PDF\RequestExportPeopleAddressEvent;
use App\Jobs\Export\PDF\ExportPeopleAddressJob;
use App\Models\Address;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;

class ExportPeopleAddressListener implements ShouldQueue
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
     * Handle the event.
     */
    public function handle(RequestExportPeopleAddressEvent $event): void
    {
        $batch = Bus::batch([])->then(function (Batch $batch) use ($event) {
            ExportedPeopleAddress::dispatch($batch->id, $event->company_id);

        })->catch(function (Batch $batch, \Throwable $e) use ($event) {
            FailedExportPeopleAddress::dispatch($batch->id, $event->company_id, $e->getMessage());
        })->name('Export People Address');

        try {
            //            $query = Person::with('address', 'groups')->whereTenantId($event->tenant_id)
            //                ->whereHas('groups', fn ($query) => $query->where('name', 'like', $event->group_name))
            //                ->when($event->district, fn ($query) => $query->whereHas('address', fn ($query) => $query->where('district', 'like', $event->district)));
            //
            //            $data = $query->get();

            $data = Address::with('person', 'person.groups')
                ->whereHas('person', function ($query) use ($event) {
                    $query->whereHas('groups', function ($query) use ($event) {
                        $query->where('name', 'like', $event->group_name);
                    });
                })
                ->when($event->district, function ($query) use ($event) {
                    $query->where('district', 'like', $event->district);
                })
                ->get();

            $data->groupBy('district')->each(function ($items) use ($batch, $event) {
                $batch->add(new ExportPeopleAddressJob(
                    data: $items,
                    filename: 'puxada',
                    company_id: $event->company_id,
                    group_by_name: $event->group_name,
                    district: $items->first()->district,
                ));
            });
        } catch (\Throwable $th) {
            report($th);
        } finally {
            $batch->dispatch();
        }
    }
}
