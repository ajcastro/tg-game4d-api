<?php

namespace App\Http\Controllers\Traits;

trait FillResource
{
    protected function fill($model, $request)
    {
        $model->fill($request->validated());
    }
}
