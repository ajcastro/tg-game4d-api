<?php

namespace App\Http\Queries;

use App\Http\Queries\BaseQuery;
use App\Http\Queries\Contracts\QueryContract;
use App\Http\Queries\CustomSorts\SortBySub;
use App\Models\ParentGroup;
use App\Models\Role;
use App\Models\User;
use App\Models\Website;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class UserQuery extends BaseQuery implements QueryContract
{
    public function __construct()
    {
        parent::__construct(
            User::query()
            ->where('is_hidden', '!=', 1)
        );
    }

    public function withFields()
    {
        $this->allowedFields([
            ...User::allowableFields(),
            ...fields('created_by', User::allowableFields()),
            ...fields('updated_by', User::allowableFields()),
        ]);

        return $this;
    }

    public function withInclude()
    {
        $this->allowedIncludes([
            'created_by', 'updated_by',
        ]);

        return $this;
    }

    public function withFilter()
    {
        $this->allowedFilters([
            AllowedFilter::callback('parent_group_id', function () {
                // todo
            }),
            AllowedFilter::callback('role_id', function () {
                // todo
            }),
            AllowedFilter::exact('is_active'),
            AllowedFilter::scope('search'),
        ]);

        return $this;
    }

    public function withSort()
    {
        $this->allowedSorts([
            ...User::allowableFields(),
            // AllowedSort::custom('role', SortBySub::make(
            //     '__role',
            //     Role::query()
            //     ->select('roles.name')
            //     ->whereColumn('users.role_id', 'roles.id')
            // )),
            AllowedSort::custom('created_by', SortBySub::make(
                '__created_by',
                User::query()
                ->select('name')
                ->whereColumn('users.created_by_id', 'users.id')
            )),
            AllowedSort::custom('updated_by', SortBySub::make(
                '__updated_by',
                User::query()
                ->select('name')
                ->whereColumn('users.updated_by_id', 'users.id')
            )),
        ]);

        return $this;
    }
}
