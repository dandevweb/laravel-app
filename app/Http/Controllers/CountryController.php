<?php

namespace App\Http\Controllers;

use App\Forms\CountryForm;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use App\Tables\Countries;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use ProtoneMedia\Splade\Facades\Splade;

class CountryController extends Controller
{
    public function index(): View
    {
        return view('admin.country.index', [
            'countries' => Countries::class,
        ]);
    }

    public function create(): View
    {
        return view('admin.form', [
            'form' => CountryForm::class,
            'title' => 'Create a new country',
        ]);
    }

    public function store(StoreCountryRequest $request): RedirectResponse
    {
        Country::create($request->validated());
        Splade::toast('Country deleted')->autoDismiss(3);

        return to_route('admin.countries.index');
    }

    public function edit(Country $country): View
    {
        $form = CountryForm::make()
            ->method('PUT')
            ->fill($country)
            ->action(route('admin.countries.update', $country));

        return view('admin.form', [
            'form' => $form,
            'title' => "Edit country: {$country->name}",
        ]);
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->update($request->validated());
        Splade::toast('Country updated')->autoDismiss(3);

        return to_route('admin.countries.index');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        Splade::toast('Country deleted')->autoDismiss(3);

        return to_route('admin.countries.index');
    }
}
