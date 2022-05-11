<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * A wrapper convenience method
     *
     * @param Closure $callback
     * @return \Illuminate\Routing\ControllerMiddlewareOptions
     */
    public function hook(Closure $callback)
    {
        return $this->middleware(function ($request, Closure $next) use ($callback) {
            $response = $callback($request, $next);
            return $response ?? $next($request);
        });
    }
}
