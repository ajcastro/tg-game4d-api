<?php

namespace App\Http\Queries;

use App\Http\Queries\BaseQuery;
use App\Http\Queries\Contracts\QueryContract;
use App\Http\Queries\CustomSorts\SortBySub;
use App\Models\ParentGroup;
use App\Models\Permission;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class PermissionQuery extends BaseQuery implements QueryContract
{
    public function __construct()
    {
        parent::__construct(Permission::query());
    }

    public function withFields()
    {
        $this->allowedFields([
            ...Permission::allowableFields(),
        ]);

        return $this;
    }

    public function withInclude()
    {
        // $this->allowedIncludes([
        // ]);

        return $this;
    }

    public function withFilter()
    {
        // $this->allowedFilters([
        //     AllowedFilter::scope('search'),
        // ]);

        return $this;
    }

    public function withSort()
    {
        $this->allowedSorts([
            ...Permission::allowableFields(),
        ]);

        return $this;
    }
}
