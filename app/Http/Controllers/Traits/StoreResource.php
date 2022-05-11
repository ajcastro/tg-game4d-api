<?php

namespace App\Http\Controllers\Traits;

use App\Http\Requests\Api\Admin\ClientRequest;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Http\Controllers\Traits\FillResource
 * @mixin \App\Http\Controllers\Traits\SaveResource
 * @mixin \App\Http\Controllers\Traits\ResolvesModel
 * @mixin \App\Http\Controllers\Traits\ResolvesRequest
 */
trait StoreResource
{
    public function store()
    {
        $request = $this->request();
        $model = $this->model()->make();

        $this->fill($model, $request);
        $this->save($model);

        return new JsonResource($model);
    }
}
