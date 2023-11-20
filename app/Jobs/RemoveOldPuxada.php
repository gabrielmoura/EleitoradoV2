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

    public int $timeDelete = 7;

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
        $collections = ['puxada', 'tag'];
        try {
            foreach ($collections as $collection) {
                $this->deleteMediaCollection($collection);
            }

        } catch (\Exception $e) {
            report($e);
        }
    }

    private function deleteMediaCollection(string $collection): void
    {
        $mediaToDelete = Media::where('collection_name', $collection)
            ->where('created_at', '<', now()->subDays($this->timeDelete))
            ->get();

        $mediaToDelete->each(function ($media) {
            $this->deleteMedia($media);
        });
    }

    private function deleteMedia($media): void
    {
        Storage::delete($media->getPath());
        $media->delete();
    }
}
