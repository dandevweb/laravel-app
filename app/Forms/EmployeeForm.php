<?php

namespace App\Forms;

use App\Models\City;
use App\Models\Department;
use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\Date;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;

class EmployeeForm extends AbstractForm
{
    public function configure(SpladeForm $form): void
    {
        $form
            ->action(route('admin.employees.store'))
            ->class('space-y-4 bg-white rounded p-4');
    }

    public function fields(): array
    {
        return [
            Input::make('first_name')->label('First Name')
                ->rules(['required', 'string', 'max:100']),

            Input::make('middle_name')->label('Middle Name')
                ->rules(['required', 'string', 'max:100']),

            Input::make('last_name')->label('Last Name')
                ->rules(['required', 'string', 'max:100']),

            Input::make('zip_code')->label('Zip Code')
                ->rules(['required', 'string', 'max:100']),

            Select::make('city_id')
                ->placeholder('Choose a city')
                ->label('City')
                ->options(City::pluck('name', 'id')->toArray())
                ->rules(['required', 'integer']),

            Select::make('department_id')
                ->placeholder('Choose a department')
                ->label('Department')
                ->options(Department::pluck('name', 'id')->toArray())
                ->rules(['required', 'integer']),

            Date::make('birth_date')
                ->label('Birth Date')
                ->rules(['required', 'date']),

            Date::make('date_hired')
                ->label('Date Hired')
                ->rules(['required', 'date']),

            Submit::make()->label(__('Submit')),
        ];
    }
}
