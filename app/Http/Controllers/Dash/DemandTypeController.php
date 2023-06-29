<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\DemandType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Activitylog\Models\Activity;

class DemandTypeController extends Controller
{
    /**
     * Lista os tipos de demanda
     */
    public function index(): View
    {
        return view('dash.demandType.index');
    }

    /**
     * Exibe o tipo de demanda
     */
    public function show(DemandType $demandType): View
    {
        return view('dash.demandType.show', compact('demandType'));
    }

    /**
     * Histórico do Tipo de Demanda
     */
    public function history($pid): View|RedirectResponse
    {
        try {
            $tag = DemandType::findPid($pid)
                ->firstOrFail();
            $histories = Activity::where('subject_type', DemandType::class)
                ->where('subject_id', $tag->id)
                ->get();

            return view('dash.demandType.history', compact('histories'));
        } catch (\Throwable $throwable) {
            report($throwable);

            return redirect()->back();
        }
    }
}
