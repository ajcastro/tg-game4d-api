<?php

namespace App\Http\Queries;

use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseQuery extends QueryBuilder
{
    public function withAllDeclarations()
    {
        return $this->withFields()
            ->withInclude()
            ->withFilter()
            ->withSort();
    }

    public function withFields()
    {
        return $this;
    }

    public function withInclude()
    {
        return $this;
    }

    public function withFilter()
    {
        return $this;
    }

    public function withSort()
    {
        return $this;
    }
}
