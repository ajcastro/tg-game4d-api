<?php

if (!function_exists('fields')) {
    /**
     * Return an array of allowedFields for the include relation of spatie/laravel-query-builder
     *
     * @param string $relation
     * @param array $fields
     * @return array
     */
    function fields($relation, array $fields)
    {
        return collect($fields)->map(function ($field) use ($relation) {
            return "{$relation}.{$field}";
        })->all();
    }
}
