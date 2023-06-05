<?php

namespace App\Repositories;

use App\Http\Requests\Demand\DemandStoreRequest;
use App\Http\Requests\Demand\DemandUpdateRequest;

interface DemandRepository
{
    public function save(DemandStoreRequest $request);

    public function update(DemandUpdateRequest $request, $id);

    public function delete($id);

    public function restore($id);

    public function getHistory($pid);

    public function getDemand($pid);
}
