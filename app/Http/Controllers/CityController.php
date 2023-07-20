<?php

namespace App\Http\Controllers;

use App\Forms\CityForm;
use App\Models\City;
use App\Tables\Cities;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use ProtoneMedia\Splade\Facades\Splade;

class CityController extends Controller
{
    public function index(): View
    {
        return view('admin.city.index', [
            'cities' => Cities::class,
        ]);
    }

    public function create(): View
    {
        return view('admin.form', [
            'form' => CityForm::class,
            'title' => 'Create a new city',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        City::create($request->validate(CityForm::rules()));
        Splade::toast('City created')->autoDismiss(3);

        return to_route('admin.cities.index');
    }

    public function edit(City $city): View
    {
        $form = CityForm::make()
            ->method('PUT')
            ->fill($city)
            ->action(route('admin.cities.update', $city));

        return view('admin.form', [
            'form' => $form,
            'title' => "Edit city: {$city->name}",
        ]);
    }

    public function update(Request $request, City $city): RedirectResponse
    {
        $city->update($request->validate(CityForm::rules()));
        Splade::toast('States updated')->autoDismiss(3);

        return to_route('admin.cities.index');
    }

    public function destroy(City $city): RedirectResponse
    {
        $city->delete();
        Splade::toast('States deleted')->autoDismiss(3);

        return to_route('admin.cities.index');
    }
}
