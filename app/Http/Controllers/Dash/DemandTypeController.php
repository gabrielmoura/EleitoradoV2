<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Demand\DemandUpdateRequest;
use App\Http\Requests\DemandType\DemandTypeStoreRequest;
use App\Models\DemandType;

class DemandTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dash.demandType.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DemandTypeStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DemandType $demandType)
    {
        return view('dash.demandType.show', compact('demandType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DemandUpdateRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
