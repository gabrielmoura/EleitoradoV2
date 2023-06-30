<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonStoreRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Models\Demand;
use App\Models\Event;
use App\Models\Group;
use App\Models\Person;
use App\Repositories\PersonRepository;
use Illuminate\Support\Facades\Gate;

class PersonController extends Controller
{
    public function __construct(private PersonRepository $personRepository)
    {
    }

    public function index()
    {
        //        $voters = Voter::with(['addresses'])->where('company_id', $this->getCompanyId())
        //            ->limit(10)->get();
        return view('dash.person.index');
    }

    public function create()
    {
        $groups = Group::orderBy('created_at')->take(10)->get();
        $events = Event::orderBy('created_at')->take(10)->get();
        $form = ['method' => 'POST', 'route' => route('dash.person.store')];
        $person = new Person();

        return view('dash.person.form', compact('form', 'groups', 'events', 'person'));
    }

    public function store(PersonStoreRequest $request)
    {

        try {
            $this->personRepository->save($request);
        } catch (\Throwable $throwable) {
            report($throwable);
            flash()->addError('Erro ao Salvar');

            return redirect()->back()->withInput()->withErrors($throwable->getMessage());
        }
        flash()->addSaved('Salvo com sucesso');

        return redirect()->route('dash.person.index');
    }

    public function update(PersonUpdateRequest $request, $id)
    {
        try {
            $this->personRepository->update($request, $id);
        } catch (\Throwable $throwable) {
            report($throwable);
            flash()->addError('Erro ao Salvar');

            return redirect()->back()->withInput()->withErrors($throwable->getMessage());
        }
        flash()->addSaved('Salvo com sucesso');

        return redirect()->route('dash.person.index');
    }

    public function show($pid)
    {
        $person = Person::findPid($pid)
            ->with(['groups', 'media', 'events', 'address'])
            ->firstOrFail();

        return view('dash.person.show', compact('person'));

    }

    public function edit($pid)
    {

        $person = $this->personRepository->getPerson($pid);

        $groups = Group::orderBy('created_at')->take(10)->get();
        $events = Event::orderBy('created_at')->take(10)->get();
        $demands = Demand::orderBy('created_at')->take(10)->get();

        $form = ['method' => 'PATCH', 'route' => route('dash.person.update', ['person' => $pid])];

        return view('dash.person.form', compact('form', 'person', 'groups', 'events', 'demands'));
    }

    public function destroy($id)
    {
        if (! Gate::allows('delete_person')) {
            abort(403);
        }
        try {
            $this->personRepository->delete($id);
            flash()->addSuccess('Salvo com sucesso');
        } catch (\Throwable $throwable) {
            report($throwable);
            flash()->addError('Erro ao Salvar');
        } finally {
            return redirect()->route('dash.voter.index');
        }
    }

    public function deleted()
    {
        try {
            return Person::withTrashed()
                ->get();
        } catch (\Throwable $throwable) {

        }
    }

    public function restore($pid)
    {
        $this->personRepository->restore($pid);
    }

    public function history($pid)
    {
        try {
            $person = $this->personRepository->getHistory($pid);

            return view('dash.person.history', compact('person'));
        } catch (\Throwable $throwable) {
            report($throwable);

            return redirect()->back();
        }
    }
}
