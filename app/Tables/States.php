<?php

namespace App\Tables;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\AbstractTable;
use Spatie\QueryBuilder\AllowedFilter;

class States extends AbstractTable
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
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhereHas('country', function ($query) use ($value) {
                            $query->where('name', 'LIKE', "%{$value}%");
                        });
                });
            });
        });

        return QueryBuilder::for(State::class)
            ->defaultSort('id')
            ->allowedSorts(['id',  'name', 'country.name'])
            ->allowedFilters(['name', 'country_id', $globalSearch]);
    }

    public function configure(SpladeTable $table): void
    {
        $table
            ->withGlobalSearch(columns: ['id', 'country', 'name'])
            ->column('id', sortable: true)
            ->column('name', sortable: true)
            ->column('country.name', label: 'Country')
            ->column('action')
            ->selectFilter(
                key: 'country_id',
                options: Country::pluck('name', 'id')->toArray(),
                label: 'Country',
            )
            ->paginate(15);
    }
}
