<?php

namespace App\Listeners\System;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;

class UpdateMediaInfoListener
{
    use InteractsWithQueue;

    private ?string $tenant_id;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->tenant_id = session()->get('tenant_id') ?? null;
    }

    /**
     * Handle the event.
     */
    public function handle(MediaHasBeenAdded $event): void
    {
        $md5 = md5_file($event->media->getPath());
        if ($md5) {
            $event->media->setCustomHeaders(['md5' => $md5]);
        }

        if ($this->tenant_id) {
            DB::table('media')
                ->where('uuid', $event->media->uuid)
                ->update(['tenant_id' => $this->tenant_id]);
        }
    }
}
