<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class EloquentAnalyticsRepository implements AnalyticsRepository
{
    /**
     * @param  string  $tenant_id uuid
     * @param  string|null  $district
     */
    public function pessoas(
        string $group_name,
        string $tenant_id,
        null|string $district = null,
        bool $checked = true,
        bool $lazy = false
    ): Collection|LazyCollection {

        $sql = DB::table('people')
            ->join('group_people', 'people.id', '=', 'group_people.person_id', 'LEFT')
            ->join('groups', 'group_people.group_id', '=', 'groups.id', 'LEFT')
            ->join('addresses', 'people.address_id', '=', 'addresses.id', 'LEFT');

        $sql->where('groups.name', '=', $group_name);
        if ($checked) {
            $sql->whereNotNull('group_people.checked_at');
        }
        if ($district) {
            $sql->where('addresses.district', '=', $district);
        }

        $sql->where('people.tenant_id', '=', $tenant_id)
            ->orderBy('addresses.district', 'ASC')
            ->select([
                'people.*',
                'groups.name AS group_name',
                'group_people.checked_at',
                'group_people.checked_by',
                'addresses.street',
                'addresses.city',
                'addresses.district',
                'addresses.state',
                'addresses.uf',
                'addresses.zipcode',
                'addresses.country',
                'addresses.number',
                'addresses.complement',
                'addresses.reference',
                'addresses.latitude',
                'addresses.longitude',
            ]);
        if ($lazy) {
            return $sql->cursor();
        }

        return $sql->get();
    }

    public function countAddressesReused(): int
    {
        return $this->showReusedAddresses()->count();
    }

    public function showReusedAddresses(): Collection
    {
        return DB::table('addresses')
            ->join('people', 'people.address_id', '=', 'addresses.id', 'LEFT')
            ->join('group_people', 'people.id', '=', 'group_people.person_id', 'LEFT')
            ->join('groups', 'group_people.group_id', '=', 'groups.id', 'LEFT')
            ->whereNotNull('group_people.checked_at')
            ->whereNotNull('people.address_id')
            ->select([
                'addresses.*',
                'people.id AS person_id',
                'people.name AS person_name',
                'people.email AS person_email',
                'people.phone AS person_phone',
                'people.cpf AS person_cpf',
                'people.tenant_id AS person_tenant_id',
                'people.created_at AS person_created_at',
                'people.updated_at AS person_updated_at',
                'people.deleted_at AS person_deleted_at',
                'group_people.id AS group_people_id',
                'group_people.person_id AS group_people_person_id',
                'group_people.group_id AS group_people_group_id',
                'group_people.checked_at AS group_people_checked_at',
                'group_people.checked_by AS group_people_checked_by',
                'group_people.created_at AS group_people_created_at',
                'group_people.updated_at AS group_people_updated_at',
                'group_people.deleted_at AS group_people_deleted_at',
                'groups.id AS group_id',
                'groups.name AS group_name',
                'groups.tenant_id AS group_tenant_id',
                'groups.created_at AS group_created_at',
                'groups.updated_at AS group_updated_at',
                'groups.deleted_at AS group_deleted_at',
            ])
            ->get();
    }

    /**
     * @description Retorna os aniversariantes do dia
     */
    public function birthdaysOfTheDay(): Collection
    {
        $now = now()->day;

        return DB::table('people')
            ->join('addresses', 'people.address_id', '=', 'addresses.id', 'LEFT')
            ->whereNotNull('people.address_id')
            ->whereDay('people.birthday', '=', $now)
            ->select([
                'people.*',
                'addresses.street',
                'addresses.city',
                'addresses.district',
                'addresses.state',
                'addresses.uf',
                'addresses.zipcode',
                'addresses.country',
                'addresses.number',
                'addresses.complement',
                'addresses.reference',
                'addresses.latitude',
                'addresses.longitude',
            ])
            ->get();
    }
}
