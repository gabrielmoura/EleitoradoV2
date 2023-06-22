<?php

namespace App\Http\Controllers\Dash;

use App\Events\Dash\User\UserCreatedEvent;
use App\Events\Dash\User\UserUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::tenant()->with('roles')->paginate(10);

        return view('dash.user.index', compact('users'));
    }

    public function create()
    {
        $form = ['method' => 'POST', 'action' => route('dash.user.store')];
        $roles = DB::table('roles')->whereNot('name', 'admin')->get();

        return view('dash.user.form', compact('form', 'roles'));
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $password = Str::password(length: 8, letters: true, numbers: true, symbols: true, spaces: false);
        $transaction = DB::transaction(function () use ($data, $password) {
            $data['password'] = $password;
            $data['company_id'] = auth()->user()->company_id;
            $user = User::create($data);
            $role = Role::where('name', $data['role'])->firstOrFail();
            $user->assignRole($role->id);

            return $user;
        });

        if ($transaction) {
            event(new UserCreatedEvent($transaction, $password));
            flash()->addSuccess('Usuário criado com sucesso.');
        }

        return redirect()->route('dash.user.index');
    }

    public function update(UserUpdateRequest $request, $pid)
    {
        $data = $request->validated();

        $user = User::tenant()->find($pid);
        $res = DB::transaction(function () use ($data, $user) {
            $data['company_id'] = auth()->user()->company_id;
            $res = $user->update($data);
            $role = Role::where('name', $data['role'])->firstOrFail();
            $user->syncRoles([$role->id]);

            return $res;
        });

        if ($res) {
            event(new UserUpdatedEvent($user));
            flash()->addSuccess('Usuário atualizado com sucesso.');
        } else {
            flash()->addWarning('Usuário não atualizado.');
        }

        return redirect()->route('dash.user.index');
    }

    public function show($id)
    {
        try {
            $user = User::tenant()->findOrFail($id);
        } catch (\Exception $e) {
            report($e);
            flash()->addWarning('Usuário não encontrado.');

            return redirect()->route('dash.user.index');
        }

        return view('dash.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $form = ['method' => 'PATCH', 'action' => route('dash.user.update', ['user' => $user->id])];
        $roles = DB::table('roles')->whereNot('name', 'admin')->get();

        return view('dash.user.form', compact('form', 'roles', 'user'));
    }

    public function destroy($id)
    {
        try {
            $user = User::tenant()->findOrFail($id);
        } catch (\Exception $e) {
            flash()->addWarning('Usuário não encontrado.');

            return redirect()->route('dash.user.index');
        }
        $user->deleteOrFail();

        return redirect()->route('dash.company.index');
    }
}
