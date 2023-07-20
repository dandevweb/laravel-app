<?php

namespace App\Http\Controllers;

use App\Forms\EmployeeForm;
use App\Models\City;
use App\Models\Employee;
use App\Tables\Employees;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use ProtoneMedia\Splade\Facades\Splade;

class EmployeeController extends Controller
{
    public function index(): View
    {
        return view('admin.employee.index', [
            'employees' => Employees::class,
        ]);
    }

    public function create(): View
    {
        return view('admin.form', [
            'form' => EmployeeForm::class,
            'title' => 'Create Employee',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(EmployeeForm::rules());

        $city = City::findOrFail($data['city_id']);

        $data['state_id'] = $city->state_id;
        $data['country_id'] = $city->state->country_id;

        Employee::create($data);

        Splade::toast('Employee created')->autoDismiss(3);

        return to_route('admin.employees.index');
    }

    public function edit(Employee $employee): View
    {
        $form = EmployeeForm::make()
            ->method('PUT')
            ->fill($employee)
            ->action(route('admin.employees.update', $employee));

        return view('admin.form', [
            'form' => $form,
            'title' => "Edit employee: {$employee->first_name}",
        ]);
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $data = $request->validate(EmployeeForm::rules());

        $city = City::find($data['city_id']);
        $data['state_id'] = $city->state_id;
        $data['country_id'] = $city->state->country_id;

        $employee->update($data);

        Splade::toast('Employee updated')->autoDismiss(3);

        return to_route('admin.employees.index');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        Splade::toast('Employee deleted')->autoDismiss(3);

        return to_route('admin.employees.index');
    }
}
