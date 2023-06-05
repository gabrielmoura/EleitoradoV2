<?php

namespace App\Repositories;

use Illuminate\Bus\Batch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class EloquentBatchRepository implements BatchRepository
{
    public function find($id): Batch
    {
        return Bus::findBatch($id);
    }

    // all batches
    public function all(): Collection
    {
        return DB::table('job_batches')
            ->whereNull('cancelled_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function allWithMethods(): Collection
    {
        return $this->all()->map(fn ($batch) => Bus::findBatch($batch->id));
    }
}
