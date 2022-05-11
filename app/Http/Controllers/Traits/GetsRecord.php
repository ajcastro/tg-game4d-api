<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Model;

trait GetsRecord
{
    public function getRecord($id)
    {
        if ($id instanceof Model) {
            return $id;
        }

        // TODO: perform caching here that will be reset on every after http requests
        return $this->model()->resolveRouteBinding($id);
    }
}
