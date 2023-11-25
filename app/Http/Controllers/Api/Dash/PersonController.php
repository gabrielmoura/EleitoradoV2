<?php

namespace App\Http\Controllers\Api\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePersonRequest;
use App\Http\Requests\Api\UpdatePersonRequest;
use App\Models\Person;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $person = Person::query();
        if ($fields = request()->get('fields')) {
            $person->select(explode(',', $fields));
        }
        if ($limit = request()->get('limit')) {
            $person->limit($limit);
        }
        if ($offset = request()->get('offset')) {
            $person->offset($offset);
        }

        return $person->cursor();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        return $person;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        //
    }
}
