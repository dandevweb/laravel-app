<?php

namespace App\Tables;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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

        return QueryBuilder::for(User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        }))
            ->defaultSort('id')
            ->allowedSorts(['id', 'username', 'last_name', 'first_name', 'email', 'created_at'])
            ->allowedFilters(['username', 'last_name', 'first_name',  'email', $globalSearch]);
    }

    public function configure(SpladeTable $table): void
    {
        $table
            ->withGlobalSearch(columns: ['id', 'username', 'last_name', 'first_name', 'email'])
            ->column('id', sortable: true)
            ->column('username', sortable: true)
            ->column('first_name', sortable: true, hidden: true)
            ->column('last_name', sortable: true, hidden: true)
            ->column('email', sortable: true)
            ->column('created_at', sortable: true, hidden: true)
            // ->rowLink(function (User $user) {
            //     return route('admin.users.edit', $user);
            // })
            ->column('action')
            ->paginate(15);

        $table->export();
    }
}
