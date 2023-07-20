<?php

namespace App\Http\Controllers;

use App\Tables\Roles;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use ProtoneMedia\Splade\Facades\Splade;
use Spatie\Permission\Models\Permission;

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
        return view('admin.role.create', [
            'permissions' => Permission::pluck('name', 'id')->toArray(),
            'title' => 'Create Role',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $role = Role::create(
            $request->validate([
                'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
                'permissions' => ['nullable']
            ])
        );

        $role->syncPermissions($request->permissions);

        Splade::toast('Role created')->autoDismiss(3);

        return to_route('admin.roles.index');
    }

    public function edit(Role $role): View
    {
        return view('admin.role.edit', [
            'role' => $role,
            'permissions' => Permission::pluck('name', 'id')->toArray(),
            'title' => "Edit Role: {$role->name}",
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $role->update(
            $request->validate([
                'name' => ['required', 'string', 'max:100', Rule::unique('roles')->ignore($role->id)],
                'permissions' => ['nullable']
            ])
        );

        $role->syncPermissions($request->permissions);

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
