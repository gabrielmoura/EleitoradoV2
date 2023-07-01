<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RemoveOldPuxada implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeDelete = 7;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Media::where('collection_name', 'puxada')
                ->where('created_at', '<', now()->subDays($this->timeDelete))->get()
                ->each(function ($media) {
                    Storage::delete($media->getPath());
                    $media->delete();
                });
        } catch (\Exception $e) {
            report($e);
        }

    }
}
