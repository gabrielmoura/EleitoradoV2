<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Models\Voter;
use App\Traits\CompanySessionTrait;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    use CompanySessionTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $data = $request->validate(['voter_pid' => 'required|string', 'description' => 'nullable']);
        try {
            $data['company_id'] = $this->getCompanyId();
            $data['user_id'] = $request->user()->id;
            Voter::where('pid', $data['voter_pid'])->firstOrFail()
                ->checkIns()->create($data);

            toastr()->success('Verificado');
            if ($request->ajax()) {
                return response()->json('ok');
            } else {
                return redirect()->route('dash.voter.index');
            }
        } catch (\Throwable $throwable) {
            report($throwable);

            toastr()->error('Erro ao Verificar');
            if ($request->ajax()) {
                return response()->json($throwable->getMessage(), '400');
            } else {
                return redirect()->route('dash.voter.index');
            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
