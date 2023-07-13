<?php

namespace App\Forms;

use App\Models\Country;
use ProtoneMedia\Splade\SpladeForm;
use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;

class StateForm extends AbstractForm
{

    public function configure(SpladeForm $form): void
    {
        $form
            ->action(route('admin.states.store'))
            ->class('space-y-4 bg-white rounded p-4');
    }

    public function fields(): array
    {
        return [
            Select::make('country_id')
                ->placeholder('Choose a country')
                ->label('Country')
                ->options(Country::pluck('name', 'id')->toArray())
                ->rules(['required', 'integer']),
            Input::make('name')->label('State Name')
                ->rules(['required', 'string', 'max:100']),
            Submit::make()->label(__('Submit')),
        ];
    }
}
