<?php

namespace App\Http\Controllers\Api\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreEventRequest;
use App\Http\Requests\Api\UpdateEventRequest;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event = Event::query();
        if ($fields = request()->get('fields')) {
            $event->select(explode(',', $fields));
        }
        if ($limit = request()->get('limit')) {
            $event->limit($limit);
        }
        if ($offset = request()->get('offset')) {
            $event->offset($offset);
        }

        return $event->cursor();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
