<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Tables\Users;
use ProtoneMedia\Splade\Facades\Splade;

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
        return view('admin.user.create');
    }

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        Splade::toast('User created')->autoDismiss(3);

        return to_route('admin.users.index');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
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
