<?php

namespace App\Repositories;

use App\Http\Requests\PersonStoreRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Models\Address;
use App\Models\Person;
use Illuminate\Support\Facades\DB;

class EloquentPersonRepository implements PersonRepository
{
    public function save(PersonStoreRequest $request): Person
    {
        return DB::transaction(function () use ($request) {
            $personData = $request->only([
                'name',
                'email',
                'cellphone',
                'telephone',
                'cpf',
                'rg',
                'address_id',
                'dateOfBirth',
                'sex',

                'voter_zone',
                'voter_section',
                'voter_registration',
                'skinColor',
                'maritalStatus',
                'educationLevel',
                'occupation',
                'religion',
                'housing',
                'sexualOrientation',
                'genderIdentity',
                'deficiencyType',
            ]);
            $person = Person::create($personData);

            $this->createAddress($request, $person);

            //        if ($request->has('media')) {
            //            $media = $request->file('media');
            //            $mediaName = $media->getClientOriginalName();
            //            $media->storeAs('public/persons/' . $person->id, $mediaName);
            //            $person->media = $mediaName;
            //            $person->save();
            //        }
            if ($request->has('events')) {
                $person->events()->sync($request->events);
            }
            if ($request->has('groups')) {
                $person->groups()->syncWithPivotValues($request->groups, ['checked_at' => now(), 'checked_by' => auth()->id()]);
            }

            return $person;
        }, 5);

    }

    public function update(PersonUpdateRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $personData = $request->only([
                'name',
                'email',
                'cellphone',
                'telephone',
                'cpf',
                'rg',
                'address_id',
                'dateOfBirth',
                'sex']);
            $person = Person::findPid($id)
                ->firstOrFail();
            $person->updateOrFail($personData);

            $this->createAddress($request, $person);

            if ($request->has('events')) {
                $person->events()->sync($request->events);
            }
            if ($request->has('groups')) {
                $person->groups()->syncWithPivotValues($request->groups, ['checked_at' => now(), 'checked_by' => auth()->id()]);
            }

            return $person;
        }, 5);

    }

    private function createAddress($request, $person): void
    {
        if ($request->has('zipcode') || $request->has('street')) {
            $addressData = $request->only([
                'zipcode',
                'street',
                'number',
                'complement',
                'district',
                'city',
                'state',
                'country',
            ]);
            $address = Address::firstOrCreate($addressData);
            $person->address()->associate($address)->save();
        }
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $person = Person::findPid($id)
                ->firstOrFail();
            $person->delete();

            return $person;
        }, 5);
    }

    public function restore($id)
    {
        return DB::transaction(function () use ($id) {
            $person = Person::withTrashed()
                ->findPid($id)
                ->firstOrFail();
            $person->restore();

            return $person;
        }, 5);
    }

    public function getHistory($pid)
    {
        return Person::withTrashed()
            ->findPid($pid)
            ->with(['checkIns', 'checkIns.user', 'tags', 'activities', 'activities.causer'])
            ->firstOrFail();
    }

    public function getPerson($pid)
    {
        return Person::findPid($pid)
            ->with(['groups', 'media', 'events', 'address'])
            ->firstOrFail();
    }
}
