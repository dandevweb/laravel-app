<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Tables\Users;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use ProtoneMedia\Splade\Facades\Splade;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index', [
            'users' => Users::class,
        ]);
    }

    public function create()
    {
        return view('admin.user.create', [
            'roles' => Role::pluck('name', 'id')->toArray(),
            'permissions' => Permission::pluck('name', 'id')->toArray(),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);
        Splade::toast('User created')->autoDismiss(3);

        return to_route('admin.users.index');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', [
            'roles' => Role::pluck('name', 'id')->toArray(),
            'permissions' => Permission::pluck('name', 'id')->toArray(),
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);
        Splade::toast('User updated')->autoDismiss(3);

        return to_route('admin.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        Splade::toast('User deleted')->autoDismiss(3);

        return to_route('admin.users.index');
    }
}
