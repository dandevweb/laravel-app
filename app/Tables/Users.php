<?php

namespace App\Tables;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\AbstractTable;
use Spatie\QueryBuilder\AllowedFilter;

class Users extends AbstractTable
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
                        ->orWhere('username', 'LIKE', "%{$value}%")
                        ->orWhere('first_name', 'LIKE', "%{$value}%")
                        ->orWhere('last_name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });

        return QueryBuilder::for(User::class)
            ->defaultSort('username')
            ->allowedSorts(['id', 'username', 'last_name', 'first_name', 'email'])
            ->allowedFilters(['username', 'last_name', 'first_name',  'email', $globalSearch]);
    }

    public function configure(SpladeTable $table): void
    {
        $table
            ->withGlobalSearch(columns: ['id', 'username', 'last_name', 'first_name', 'email'])
            ->column('id', sortable: true)
            ->column('username', sortable: true)
            ->column('first_name', sortable: true)
            ->column('last_name', sortable: true)
            ->column('email', sortable: true)
            ->paginate(15);
    }
}
