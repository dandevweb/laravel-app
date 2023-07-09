<?php

namespace App\Tables;

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
        //TODO: need change column country name as country and sort by country
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
            ->defaultSort('name')
            ->allowedSorts(['id', 'country.name', 'name'])
            ->allowedFilters(['country.name', 'name', $globalSearch]);
    }

    public function configure(SpladeTable $table): void
    {
        $table
            ->withGlobalSearch(columns: ['id', 'country', 'name'])
            ->column('id', sortable: true)
            ->column('country.name', sortable: false)
            ->column('name', sortable: true)
            ->paginate(15);
    }
}
