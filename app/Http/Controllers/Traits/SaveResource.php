<?php

namespace App\Http\Controllers\Traits;

trait SaveResource
{
    protected function save($model)
    {
        $model->save();
    }
}
