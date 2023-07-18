<?php

namespace App\Forms;

use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;

class DepartmentForm extends AbstractForm
{
    public function configure(SpladeForm $form): void
    {
        $form
            ->action(route('admin.departments.store'))
            ->class('space-y-4 bg-white rounded p-4');
    }

    public function fields(): array
    {
        return [
            Input::make('name')->label('Department Name')
                ->rules(['required', 'string', 'max:100']),
            Submit::make()->label(__('Submit')),
        ];
    }
}
