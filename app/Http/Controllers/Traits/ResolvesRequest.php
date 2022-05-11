<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

trait ResolvesRequest
{
    protected string $request;

    public function request(): FormRequest|Request
    {
        return isset($this->request)
            ? app($this->request)
            : request();
    }
}
