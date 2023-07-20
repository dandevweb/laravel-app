<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Tables\Permissions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use ProtoneMedia\Splade\Facades\Splade;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(): View
    {
        return view('admin.permission.index', [
            'permissions' => Permissions::class,
        ]);
    }

    public function create(): View
    {
        return view('admin.permission.create', [
            'roles' => Role::pluck('name', 'id')->toArray(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $permission = Permission::create(
            $request->validate([
                'name' => ['required', 'string', 'max:100', 'unique:permissions,name'],
                'roles' => ['nullable'],
            ])
        );

        $permission->syncRoles($request->roles);

        Splade::toast('Permission created')->autoDismiss(3);

        return to_route('admin.permissions.index');
    }

    public function edit(Permission $permission): View
    {
        return view('admin.permission.edit', [
            'roles' => Role::pluck('name', 'id')->toArray(),
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $permission->update(
            $request->validate([
                'name' => ['required', 'string', 'max:100', Rule::unique('permissions')->ignore($permission->id)],
                'roles' => ['nullable'],
            ])
        );

        $permission->syncRoles($request->roles);

        Splade::toast('Permission updated')->autoDismiss(3);

        return to_route('admin.permissions.index');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();
        Splade::toast('Permission deleted')->autoDismiss(3);

        return to_route('admin.permissions.index');
    }
}
