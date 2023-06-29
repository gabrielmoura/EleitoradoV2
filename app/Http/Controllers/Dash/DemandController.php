<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Demand\DemandStoreRequest;
use App\Http\Requests\Demand\DemandUpdateRequest;
use App\Models\Demand;
use App\Repositories\DemandRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Activitylog\Models\Activity;

class DemandController extends Controller
{
    public function __construct(private readonly DemandRepository $demandRepository)
    {
    }

    public function index(): View
    {
        return view('dash.demand.index');
    }

    public function store(DemandStoreRequest $request): RedirectResponse
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

    public function show(Demand $demand): View
    {
        return view('dash.demand.show', compact('demand'));
    }

    public function update(DemandUpdateRequest $request, string $id): RedirectResponse
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

    public function history($pid): View|RedirectResponse
    {
        try {
            $tag = Demand::findPid($pid)
                ->firstOrFail();
            $histories = Activity::where('subject_type', Demand::class)
                ->where('subject_id', $tag->id)
                ->get();

            return view('dash.demand.history', compact('histories'));
        } catch (\Throwable $throwable) {
            report($throwable);

            return redirect()->back();
        }
    }
}
