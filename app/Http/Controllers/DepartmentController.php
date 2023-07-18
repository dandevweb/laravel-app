<?php

namespace App\Http\Controllers;

use App\Forms\DepartmentForm;
use App\Models\Department;
use App\Tables\Departments;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use ProtoneMedia\Splade\Facades\Splade;

class DepartmentController extends Controller
{
    public function index(): View
    {
        return view('admin.department.index', [
            'departments' => Departments::class,
        ]);
    }

    public function create(): View
    {
        return view('admin.form', [
            'form' => DepartmentForm::class,
            'title' => 'Create a new department',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Department::create($request->validate(DepartmentForm::rules()));
        Splade::toast('Department created')->autoDismiss(3);

        return to_route('admin.departments.index');
    }

    public function edit(Department $department): View
    {
        $form = DepartmentForm::make()
            ->method('PUT')
            ->fill($department)
            ->action(route('admin.departments.update', $department));

        return view('admin.form', [
            'form' => $form,
            'title' => "Edit department: {$department->name}",
        ]);
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $department->update($request->validate(DepartmentForm::rules()));
        Splade::toast('Department updated')->autoDismiss(3);

        return to_route('admin.departments.index');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();
        Splade::toast('Department deleted')->autoDismiss(3);

        return to_route('admin.departments.index');
    }
}
