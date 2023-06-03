<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use App\Models\TagGroup;
use App\Models\Voter;
use App\Traits\CompanySessionTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use CompanySessionTrait;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $events = Event::where('company_id', $this->getCompanyId())
            ->with('voters', 'address')->get();
        return view('dash.event.index', compact('events'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $form = ['method' => 'POST', 'route' => ['dash.event.store']];
        return view('dash.event.form', compact('form'));
    }

    /**
     * @param $pid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($pid)
    {
        $event = Event::where('pid', $pid)
            ->where('company_id', $this->getCompanyId())
            ->with('voters', 'address')
            ->firstOrFail();
        return view('dash.event.show', compact('event'));
    }

    /**
     * @param $pid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($pid)
    {
        $event = Event::where('pid', $pid)
            ->where('company_id', $this->getCompanyId())
            ->with(['address'])
            ->firstOrFail();
        $form = ['method' => 'PATCH', 'route' => ['dash.event.update', 'event' => $pid]];
        return view('dash.event.form', compact('form', 'event'));
    }

    /**
     * @param EventStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EventStoreRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = $this->getCompanyId();
        try {
            $event = Event::create($data);
            $this->setAddress($request, $event);
            toastr()->success('Salvo com sucesso', 'Sucesso');
        } catch (\Throwable $throwable) {
            report($throwable);
            toastr()->error('Erro ao Salvar', 'Erro');
        } finally {
            return redirect()->route('dash.event.index');
        }
    }

    /**
     * @param EventUpdateRequest $request
     * @param $pid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EventUpdateRequest $request, $pid)
    {
        $data = $request->validated();
        $data['company_id'] = $this->getCompanyId();
        try {
            $event = Event::where('pid', $pid)
                ->where('company_id', $this->getCompanyId())
                ->firstOrFail();
            $event->updateOrFail($data);
            $this->setAddress($request, $event);
            toastr()->success('Salvo com sucesso', 'Sucesso');
        } catch (\Throwable $throwable) {
            report($throwable);
            toastr()->error('Erro ao Salvar', 'Erro');
        } finally {
            return redirect()->route('dash.event.index');
        }
    }

    /**
     * @param $pid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($pid)
    {
        try {
            Event::where('pid', $pid)
                ->where('company_id', $this->getCompanyId())
                ->firstOrFail()
                ->deleteOrFail();
            toastr()->success('Removido com sucesso', 'Sucesso');
        } catch (\Throwable $throwable) {
            report($throwable);
            toastr()->error('Erro ao Remover', 'Erro');
        } finally {
            return redirect()->route('dash.event.index');
        }
    }

    /**
     * @param EventUpdateRequest|EventStoreRequest $request
     * @param \Illuminate\Database\Eloquent\Model|Event|\Illuminate\Database\Eloquent\Builder $event
     * @return void
     */
    private function setAddress(EventUpdateRequest|EventStoreRequest $request, Model|Event|Builder $event): void
    {
        if ($request->has('post_code') || $request->has('street')) {
            $address = $request->only(['post_code'
                , 'street'
                , 'number'
                , 'complement'
                , 'district'
                , 'city'
                , 'state'
                , 'country']);
            $address['is_primary'] = true;
            if ($event->address()->exists()) {
                $event->address()->update($address);
            } else {
                $event->address()->create($address);
            }
        }

    }
}
