<?php

namespace App\Observers;

class SetsCreatedByAndUpdatedBy
{
    public function creating($model)
    {
        $model->created_by_id = $model->created_by_id ?? auth()->user()->id ?? 1;
        $model->updated_by_id = $model->created_by_id ?? auth()->user()->id ?? 1;
    }

    public function updating($model)
    {
        $model->updated_by_id = auth()->user()->id ?? 1;
    }
}
