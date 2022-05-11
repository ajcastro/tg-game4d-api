<?php

if (!function_exists('memo')) {
    function memo($key, $callback, $store = null)
    {
        if (app()->runningUnitTests()) {
            return value($callback);
        }

        $key = is_array($key) ? implode('.', $key) : $key;

        return cache()->store($store ?? 'array')->rememberForever($key, $callback);
    }
}
