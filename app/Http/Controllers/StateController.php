<?php

namespace App\Http\Controllers;

use App\Forms\StateForm;
use App\Models\State;
use App\Tables\States;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use ProtoneMedia\Splade\Facades\Splade;

class StateController extends Controller
{
    public function index(): View
    {
        return view('admin.state.index', [
            'states' => States::class,
        ]);
    }

    public function create(): View
    {
        return view('admin.form', [
            'form' => StateForm::class,
            'title' => 'Create a new state',
        ]);
    }

    public function store(Request $request, StateForm $form): RedirectResponse
    {
        State::create($form->validate($request));
        Splade::toast('States created')->autoDismiss(3);

        return to_route('admin.states.index');
    }

    public function edit(State $state): View
    {
        $form = StateForm::make()
            ->method('PUT')
            ->fill($state)
            ->action(route('admin.states.update', $state));

        return view('admin.form', [
            'form' => $form,
            'title' => "Edit state: {$state->name}",
        ]);
    }

    public function update(Request $request, State $state): RedirectResponse
    {
        $state->update($request->validate(StateForm::rules()));
        Splade::toast('States updated')->autoDismiss(3);

        return to_route('admin.states.index');
    }

    public function destroy(State $state): RedirectResponse
    {
        $state->delete();
        Splade::toast('States deleted')->autoDismiss(3);

        return to_route('admin.states.index');
    }
}
