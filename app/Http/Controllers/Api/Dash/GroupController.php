<?php

namespace App\Http\Controllers\Api\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreGroupRequest;
use App\Http\Requests\Api\UpdateGroupRequest;
use App\Models\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $group = Group::query();
        if ($fields = request()->get('fields')) {
            $group->select(explode(',', $fields));
        }
        if ($limit = request()->get('limit')) {
            $group->limit($limit);
        }
        if ($offset = request()->get('offset')) {
            $group->offset($offset);
        }

        return $group->cursor();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
