<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\Company\WelcomeCompanyMail;
use App\Models\Employee;
use App\Models\User;
use App\Traits\CompanySessionTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
//    use CompanySessionTrait;

    public function index()
    {
        $companies = DB::table('users')->get();
        return view('dash.company.index', compact('companies'));
    }

    public function create()
    {
        $form = ['method' => 'POST', 'route' => ['dash.user.store']];
        return view('dash.user.form', compact('form'));
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        $transaction = DB::transaction(function () use ($data) {
            $data['company_id'] = $this->getCompanyId();
            $user = User::create($data);
            $user->assignRole('employees');
            return $user;
        });
        if ($transaction) {
            Mail::to($transaction)->send(new WelcomeCompanyMail($this->getCompanyName(), $request->user()->toArray()));
            toastr()->success('Usuário criado com sucesso.');
        }
        return redirect()->route('dash.company.index');
    }

    public function update(UserUpdateRequest $request, $pid)
    {
        $data = $request->validated();
        User::wherePid($pid)->firstOrFail()->update($data);
        return redirect()->route('dash.company.index');
    }

    public function show($pid)
    {
        $company = User::wherePid($pid)->firstOrFail();
        return view('dash.company.show', compact('company'));
    }

    public function edit($pid)
    {
        $company = User::wherePid($pid)->firstOrFail();
        $form = ['method' => 'PATCH', 'route' => ['dash.user.update', 'user' => $pid]];
        return view(null, compact('company', 'form'));
    }

    public function destroy($pid)
    {
        User::wherePid($pid)->firstOrFail()->deleteOrFail();
        return redirect()->route('dash.company.index');
    }
}
