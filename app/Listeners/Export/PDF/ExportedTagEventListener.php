<?php

namespace App\Listeners\Export\PDF;

use App\Events\Export\PDF\ExportedTagEvent;
use App\Notifications\System\GenericNotification;

class ExportedTagEventListener
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
    public function handle(ExportedTagEvent $event): void
    {
        $company = \App\Models\Company::find($event->companyId);
        $company->notify(new GenericNotification(
            text: 'Tag Disponível',
            date: now(),
            url: route('dash.report.get', ['id' => $event->batchId, 'name' => 'Tag']),
            uid: $event->batchId,
        ));
    }
}
