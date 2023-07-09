<?php

namespace App\Tables;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\AbstractTable;
use Spatie\QueryBuilder\AllowedFilter;

class Departments extends AbstractTable
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
                        ->orWhere('name', 'LIKE', "%{$value}%");
                });
            });
        });

        return QueryBuilder::for(Department::class)
            ->defaultSort('name')
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(['name', $globalSearch]);
    }

    public function configure(SpladeTable $table): void
    {
        $table
            ->withGlobalSearch(columns: ['id', 'name'])
            ->column('id', sortable: true)
            ->column('name', sortable: true)
            ->paginate(15);
    }
}
