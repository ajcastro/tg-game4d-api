<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait SetActiveStatus
{
    public function setActiveStatus($id, Request $request)
    {
        $instance = $this->model()->resolveRouteBinding($id);

        $instance->setActive($request->boolean('is_active', true))->save();
    }
}
