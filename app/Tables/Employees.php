<?php

namespace App\Tables;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Employees extends AbstractTable
{
    public function __construct()
    {
        //
    }

    public function authorize(Request $request): bool
    {
        return true;
    }

    public function for(): QueryBuilder
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('first_name', 'LIKE', "%{$value}%")
                        ->orWhere('middle_name', 'LIKE', "%{$value}%")
                        ->orWhere('last_name', 'LIKE', "%{$value}%")
                        ->orWhere('zip_code', 'LIKE', "%{$value}%")
                        ->orWhere('birth_date', 'LIKE', "%{$value}%")
                        ->orWhere('date_hired', 'LIKE', "%{$value}%")
                        ->orWhereHas('department', function ($query) use ($value) {
                            $query->where('name', 'LIKE', "%{$value}%");
                        })
                        ->orWhereHas('country', function ($query) use ($value) {
                            $query->where('name', 'LIKE', "%{$value}%");
                        })
                        ->orWhereHas('state', function ($query) use ($value) {
                            $query->where('name', 'LIKE', "%{$value}%");
                        })
                        ->orWhereHas('city', function ($query) use ($value) {
                            $query->where('name', 'LIKE', "%{$value}%");
                        });
                });
            });
        });

        return QueryBuilder::for(Employee::class)
            ->defaultSort('id')
            ->allowedSorts([
                'id',
                'first_name',
                'middle_name',
                'first_name',
                'last_name',
                'department.name',
                'country.name',
                'state.name',
                'city.name',
                'zip_code',
                'birth_date',
                'date_hired',
            ])
            ->allowedFilters([
                'first_name',
                'middle_name',
                'last_name',
                'department_id',
                'country_id',
                'state_id',
                'city_id',
                'zip_code',
                'birth_date',
                'date_hired',
                $globalSearch,
            ]);
    }

    public function configure(SpladeTable $table): void
    {
        $table
            ->withGlobalSearch(columns: [
                'id',
                'first_name',
                'middle_name',
                'first_name',
                'last_name',
                'department',
                'country',
                'state',
                'city',
                'zip_code',
                'birth_date',
                'date_hired',
            ])
            ->column('id', sortable: true)
            ->column('first_name', sortable: true)
            ->column('middle_name', sortable: true, hidden: true)
            ->column('last_name', sortable: true)
            ->column('department.name', label: 'Department', sortable: true)
            ->column('country.name', label: 'Country', sortable: true, hidden: true)
            ->column('state.name', label: 'State', sortable: true, hidden: true)
            ->column('city.name', label: 'City', sortable: true)
            ->column('zip_code', sortable: true, hidden: true)
            ->column('birth_date', sortable: true, hidden: true)
            ->column('date_hired', sortable: true, hidden: true)
            ->column('action')
            ->selectFilter(
                key: 'department_id',
                options: Department::pluck('name', 'id')->toArray(),
                label: 'Department',
            )
            ->selectFilter(
                key: 'country_id',
                options: Country::pluck('name', 'id')->toArray(),
                label: 'Country',
            )
            ->selectFilter(
                key: 'state_id',
                options: State::pluck('name', 'id')->toArray(),
                label: 'State',
            )
            ->selectFilter(
                key: 'city_id',
                options: City::pluck('name', 'id')->toArray(),
                label: 'City',

            )
            ->paginate(15);

        $table->export();
    }
}
