<?php

namespace App\Http\Controllers\Traits;

trait DeleteResource
{
    public function destroy($id)
    {
        $instance = $this->model()->resolveRouteBinding($id);
        $instance->delete();

        return response()->noContent();
    }
}
