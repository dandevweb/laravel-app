<?php

namespace App\Forms;

use App\Models\State;
use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;

class CityForm extends AbstractForm
{
    public function configure(SpladeForm $form): void
    {
        $form
            ->action(route('admin.cities.store'))
            ->class('space-y-4 bg-white rounded p-4');
    }

    public function fields(): array
    {
        return [
            Select::make('state_id')
                ->placeholder('Choose a state')
                ->label('State')
                ->options(State::pluck('name', 'id')->toArray())
                ->rules(['required', 'integer']),
            Input::make('name')->label('City Name')
                ->rules(['required', 'string', 'max:100']),
            Submit::make()->label(__('Submit')),
        ];
    }
}
