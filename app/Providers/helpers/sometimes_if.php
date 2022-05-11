<?php

use Illuminate\Support\Arr;

if (!function_exists('sometimes_if')) {
    function sometimes_if($truthy, array $rules)
    {
        if ($truthy) {
            return array_map(function ($rule) {
                return [
                    'sometimes',
                    ...Arr::wrap($rule),
                ];
            }, $rules);
        }

        return $rules;
    }
}
