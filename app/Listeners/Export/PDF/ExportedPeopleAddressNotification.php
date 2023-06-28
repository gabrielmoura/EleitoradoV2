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
        $company->notify(new GenericNotification('Puxada Disponível', now(), route('dash.reportGroup.get', ['id' => $event->batchId])));
    }
}
