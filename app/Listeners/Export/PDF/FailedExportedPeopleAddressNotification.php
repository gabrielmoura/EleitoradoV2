<?php

namespace App\Listeners\Export\PDF;

use App\Events\Export\PDF\FailedExportPeopleAddress;
use App\Notifications\System\GenericNotification;

class FailedExportedPeopleAddressNotification
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
    public function handle(FailedExportPeopleAddress $event): void
    {
        $company = \App\Models\Company::find($event->companyId);
        $company->notify(new GenericNotification('Puxada Com Erro', now(), ''));
    }
}
