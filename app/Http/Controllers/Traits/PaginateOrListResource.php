<?php

namespace App\Http\Controllers\Traits;

use App\Http\Queries\Contracts\QueryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

trait PaginateOrListResource
{
    protected QueryContract|Builder $query;

    protected string $resource;

    public function index(Request $request)
    {
        $query = $this->query instanceof QueryContract
            ? $this->query->withAllDeclarations()
            : $this->query; // can be an eloquent builder only not instance of QueryContract

        $collection = $this->shouldPaginateResource($request)
            ? $query->paginate($request->per_page ?? $request->limit)
            : $query->get();

        return $this->resource()::collection($collection);
    }

    protected function resource(): string
    {
        return $this->resource ?? JsonResource::class;
    }

    protected function shouldPaginateResource(Request $request)
    {
        return $request->boolean('paginate', true);
    }
}
