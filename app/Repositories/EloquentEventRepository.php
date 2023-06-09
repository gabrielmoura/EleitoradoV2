<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EloquentEventRepository implements EventRepository
{
    public function atualizar(array $dados, string $updateEventId)
    {
        return DB::transaction(function () use ($dados, $updateEventId) {
            $event = Event::findOrFail($updateEventId);

            return $event->update($dados);
        });
    }

    public function criar(array $dados, int $id)
    {
        //
    }
}
