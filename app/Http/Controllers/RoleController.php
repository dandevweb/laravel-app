<?php

namespace App\Http\Controllers;

use App\Tables\Roles;
use App\Forms\RoleForm;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use ProtoneMedia\Splade\Facades\Splade;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('admin.role.index', [
            'roles' => Roles::class,
        ]);
    }

    public function create(): View
    {
        return view('admin.form', [
            'form' => RoleForm::class,
            'title' => 'Create Role',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Role::create($request->validate(RoleForm::rules()));
        Splade::toast('Role created')->autoDismiss(3);

        return to_route('admin.roles.index');
    }

    public function edit(Role $role): View
    {
        $form = RoleForm::make()
            ->method('PUT')
            ->fill($role)
            ->action(route('admin.roles.update', $role));

        return view('admin.form', [
            'form' => $form,
            'title' => "Edit Role: {$role->name}",
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $role->update($request->validate(RoleForm::rules()));
        Splade::toast('Role updated')->autoDismiss(3);

        return to_route('admin.roles.index');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        Splade::toast('Role deleted')->autoDismiss(3);

        return to_route('admin.roles.index');
    }
}
