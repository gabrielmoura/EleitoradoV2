<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\System\WelcomeSystemMail;
use App\Models\User;
use App\Traits\CompanySessionTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    //    use CompanySessionTrait;

    public function index()
    {
        //users with company
        $users = DB::table('users')->leftJoin('companies', 'users.company_id', '=', 'companies.id')
            ->select('users.*', 'companies.name as company_name')
            ->get();

        return view('admin.user.index', compact('users'));
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $transaction = DB::transaction(function () use ($data) {
            $user = User::create($data);
            $user->assignRole('manager');

            return $user;
        });
        if ($transaction) {
            Mail::to($transaction)->send(new WelcomeSystemMail());
            toastr()->success('Usuário criado com sucesso.');
        }

        return redirect()->route('admin.company.index');
    }

    public function create()
    {
        $form = ['method' => 'POST', 'route' => ['admin.user.store']];

        return view('admin.user.form', compact('form'));
    }

    public function update(UserUpdateRequest $request, $pid)
    {
        $data = $request->validated();
        User::wherePid($pid)->firstOrFail()->update($data);

        return redirect()->route('admin.company.index');
    }

    public function show(User $user)
    {
        //        $user = User::find($pid)->firstOrFail();

        return view('admin.user.show', compact('user'));
    }

    public function edit($pid)
    {
        $company = User::wherePid($pid)->firstOrFail();
        $form = ['method' => 'PATCH', 'route' => ['admin.user.update', 'user' => $pid]];

        return view(null, compact('company', 'form'));
    }

    public function destroy($pid)
    {
        User::wherePid($pid)->firstOrFail()->deleteOrFail();

        return redirect()->route('admin.company.index');
    }
}
