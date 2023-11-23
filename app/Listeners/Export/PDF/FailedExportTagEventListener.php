<?php

namespace App\Listeners\Export\PDF;

use App\Events\Export\PDF\FailedExportTagEvent;
use App\Notifications\System\GenericNotification;

class FailedExportTagEventListener
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
    public function handle(FailedExportTagEvent $event): void
    {
        $company = \App\Models\Company::find($event->companyId);
        $company->notify(new GenericNotification('Tag Com Erro', now(), ''));
    }
}
