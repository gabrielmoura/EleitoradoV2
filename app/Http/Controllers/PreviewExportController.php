<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Event;
use Illuminate\Support\Collection;

class PreviewExportController extends Controller
{
    public function index($name)
    {
        $param = request()->get('param');
        if (method_exists($this, $name)) {
            return $this->$name($param);
        }
    }

    protected function puxada($param)
    {
        //        $query = Person::with('address', 'groups')->whereTenantId(session()->get('tenant_id'))
        //            ->whereHas('groups', fn ($query) => $query->where('name', 'like', 'Teste'))
        //            ->when($param, fn ($query) => $query->whereHas('address', fn ($query) => $query->where('district', 'like', $param)));
        //
        //        $data = $query->get();

        $group = 'Teste';
        $streets = $this->prepare(Address::with('person', 'person.groups')
            ->whereHas('person', function ($query) use ($group) {
                $query->whereHas('groups', function ($query) use ($group) {
                    $query->where('name', 'like', $group);
                });
            })
            ->when($param, function ($query) use ($param) {
                $query->where('district', 'like', $param);
            })
            ->get());

        $group_name = $group;

        return view('export.pdf.puxada-1', compact('streets', 'group_name'));
    }

    protected function tag($param)
    {
        $data = Event::find(1)?->persons()->with('address')->get();
        $tag_name = 'tag_name';
        if (! $data) {
            abort(404, 'Evento não encontrado');
        }

        return view('export.pdf.tag-1', compact('data', 'tag_name'));
    }

    protected function licensePlate($param)
    {
        $group = 'Teste';
        $streets = $this->prepare(Address::with('person', 'person.groups')
            ->whereHas('person', function ($query) use ($group) {
                $query->whereHas('groups', function ($query) use ($group) {
                    $query->where('name', 'like', $group);
                });
            })
            ->when($param, function ($query) use ($param) {
                $query->where('district', 'like', $param);
            })
            ->get());
        $company = Company::first();

        $group_name = $group;

        return view('export.pdf.license-plate', compact('streets', 'group_name', 'company'));
    }

    private function prepare(Collection $data): Collection
    {
        return $data->groupBy('street')
            ->map(function ($street, $key) {
                return [
                    'name' => $key,
                    'even_address' => $street->filter(fn ($person) => $person->number % 2 === 0)->map(function ($address) {
                        $love = $address->person;
                        $love->address = $address;
                        $love->checked_at = $address->person->groups->first()->pivot->checked_at;

                        return $love;
                    }),
                    'odd_address' => $street->filter(fn ($person) => $person->number % 2 === 1)->map(function ($address) {
                        $love = $address->person;
                        $love->address = $address;
                        $love->checked_at = $address->person->groups->first()->pivot->checked_at;

                        return $love;
                    }),
                ];
            });
    }
}
