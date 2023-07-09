<?php

namespace App\Tables;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\AbstractTable;
use Spatie\QueryBuilder\AllowedFilter;

class Cities extends AbstractTable
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
        //TODO: need change column state name as state and sort by state
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhereHas('state', function ($query) use ($value) {
                            $query
                                ->where('name', 'LIKE', "%{$value}%");
                        });
                });
            });
        });

        return QueryBuilder::for(City::class)
            ->defaultSort('name')
            ->allowedSorts(['id', 'state.name', 'name'])
            ->allowedFilters(['state.name as state', 'name', $globalSearch]);
    }

    public function configure(SpladeTable $table): void
    {
        $table
            ->withGlobalSearch(columns: ['id', 'state', 'name'])
            ->column('id', sortable: true)
            ->column('state.name', sortable: false)
            ->column('name', sortable: true)
            ->paginate(15);
    }
}
