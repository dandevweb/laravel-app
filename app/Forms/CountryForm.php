<?php

namespace App\Forms;

use ProtoneMedia\Splade\SpladeForm;
use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Submit;

class CountryForm extends AbstractForm
{
    public function configure(SpladeForm $form): void
    {
        $form
            ->action(route('admin.countries.store'))
            ->class('space-y-4 bg-white rounded p-4');
    }

    public function fields(): array
    {
        return [
            Input::make('country_code')->label('Country Code'),
            Input::make('name')->label('Country Name'),
            Submit::make()->label(__('Create')),
        ];
    }
}
