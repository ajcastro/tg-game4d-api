<?php

namespace App\Http\Queries;

use App\Http\Queries\BaseQuery;
use App\Http\Queries\Contracts\QueryContract;
use App\Http\Queries\CustomSorts\SortBySub;
use App\Models\ParentGroup;
use App\Models\Role;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class RoleQuery extends BaseQuery implements QueryContract
{
    public function __construct()
    {
        parent::__construct(Role::applyAccessibilityFilter());
    }

    public function withFields()
    {
        $this->allowedFields([
            ...Role::allowableFields(),
            ...fields('parent_group', ParentGroup::allowableFields()),
            ...fields('updated_by', User::allowableFields()),
        ]);

        return $this;
    }

    public function withInclude()
    {
        $this->allowedIncludes([
            'parent_group',
            'updated_by',
        ]);

        return $this;
    }

    public function withFilter()
    {
        $this->allowedFilters([
            AllowedFilter::scope('search'),
            AllowedFilter::exact('parent_group_id'),
            AllowedFilter::exact('is_active'),
        ]);

        return $this;
    }

    public function withSort()
    {
        $this->allowedSorts([
            ...Role::allowableFields(),
            AllowedSort::custom('parent_group_code', SortBySub::make(
                '__parent_group_code',
                ParentGroup::query()
                ->select('code')
                ->whereColumn('roles.parent_group_id', 'parent_groups.id')
            )),
            AllowedSort::custom('updated_by', SortBySub::make(
                '__updated_by',
                User::query()
                ->select('name')
                ->whereColumn('roles.updated_by_id', 'users.id')
            )),
        ]);

        return $this;
    }
}
