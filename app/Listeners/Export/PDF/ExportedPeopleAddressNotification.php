<?php

namespace App\Listeners\Export\PDF;

use App\Events\Export\PDF\ExportedPeopleAddress;
use App\Notifications\System\GenericNotification;

class ExportedPeopleAddressNotification
{
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
    public function handle(ExportedPeopleAddress $event): void
    {
        //        $event->user->notify(new \App\Notifications\Export\PDF\ExportedPeopleAddress($event->file));
        $company = \App\Models\Company::find($event->companyId);
        $company->notify(new GenericNotification(
            text: 'Puxada Disponível',
            date: now(),
            url: route('dash.report.get', ['id' => $event->batchId, 'name' => 'Puxada']),
            uid: $event->batchId,
        ));
    }
}
