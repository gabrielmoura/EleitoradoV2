<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Demand\DemandStoreRequest;
use App\Http\Requests\Demand\DemandUpdateRequest;
use App\Repositories\DemandRepository;

class DemandController extends Controller
{
    public function __construct(private readonly DemandRepository $demandRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DemandStoreRequest $request)
    {
        try {
            $this->demandRepository->save($request);
        } catch (\Throwable $throwable) {
            report($throwable);
            flash()->addError('Erro ao Salvar');

            return redirect()->back()->withInput()->withErrors($throwable->getMessage());
        }
        flash()->addSaved('Salvo com sucesso');

        return to_route('dash.demand.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        try {
            $this->demandRepository->update($request, $id);
        } catch (\Throwable $throwable) {
            report($throwable);
            flash()->addError('Erro ao Salvar');

            return redirect()->back()->withInput()->withErrors($throwable->getMessage());
        }
        flash()->addSaved('Salvo com sucesso');

        return to_route('dash.demand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
