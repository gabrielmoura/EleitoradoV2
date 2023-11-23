<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Person;

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
        $query = Person::with('address', 'groups')->whereTenantId(session()->get('tenant_id'))
            ->whereHas('groups', fn ($query) => $query->where('name', 'like', 'Teste'))
            ->when($param, fn ($query) => $query->whereHas('address', fn ($query) => $query->where('district', 'like', $param)));

        $data = $query->get();
        $group_name = 'group_name';

        return view('export.pdf.puxada', compact('data', 'group_name'));
    }

    protected function tag($param)
    {
        $data = Event::find(1)?->persons()->with('address')->get();
        $tag_name = 'tag_name';
        if (! $data) {
            abort(404, 'Evento não encontrado');
        }

        return view('export.pdf.tag', compact('data', 'tag_name'));
    }

    protected function licensePlate($param)
    {
        $street['odd_people'] = 1;
        $street['even_people'] = 1;

        return view('export.pdf.license-plate', [
            'streets' => $street,
        ]);
    }
}
