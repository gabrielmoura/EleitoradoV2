<?php

namespace App\Repositories;

use App\Http\Requests\PersonStoreRequest;
use App\Http\Requests\PersonUpdateRequest;

interface PersonRepository
{
    public function save(PersonStoreRequest $request);

    public function update(PersonUpdateRequest $request, $id);

    public function delete($id);

    public function restore($id);

    public function getHistory($pid);

    public function getPerson($pid);
}
