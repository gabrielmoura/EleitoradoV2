<?php

namespace App\Repositories;

use App\Events\Demand\DemandCreatedEvent;
use App\Http\Requests\Demand\DemandStoreRequest;
use App\Http\Requests\Demand\DemandUpdateRequest;
use App\Models\Demand;

class EloquentDemandRepository implements DemandRepository
{
    public function save(DemandStoreRequest $request)
    {
        $data = $request->only([
            'name',
            'description',
            'priority',
            'active',
            'demand_type_id',
            'status',
            'solution_date',
            'closed_at',
            'priority',
        ]);
        $demand = Demand::create($data);
        if ($demand) {
            event(new DemandCreatedEvent($demand->id, auth()->id()));
        }

        return $demand;
    }

    public function update(DemandUpdateRequest $request, $id)
    {
        return Demand::find($id)->update($request->all());
    }

    public function delete($id)
    {
        return Demand::destroy($id);
    }

    public function restore($id)
    {
        return Demand::withTrashed()->find($id)->restore();
    }

    public function getHistory($pid)
    {
        // TODO: Implement getHistory() method.
    }

    public function getDemand($pid)
    {
        // TODO: Implement getDemand() method.
    }
}
