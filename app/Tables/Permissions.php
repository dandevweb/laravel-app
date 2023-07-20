<?php

namespace App\Tables;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\AbstractTable;
use Spatie\Permission\Models\Permission;
use Spatie\QueryBuilder\AllowedFilter;

class Permissions extends AbstractTable
{
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
                        ->orWhere('name', 'LIKE', "%{$value}%");
                });
            });
        });

        return QueryBuilder::for(Permission::class)
            ->defaultSort('id')
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(['name', $globalSearch]);
    }

    public function configure(SpladeTable $table): void
    {
        $table
            ->withGlobalSearch(columns: ['id', 'name'])
            ->column('id', sortable: true)
            ->column('name', sortable: true)
            ->column('action')
            ->paginate(10);
    }
}
