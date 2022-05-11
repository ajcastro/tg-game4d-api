<?php

if (!function_exists('remember')) {
    function remember($key, $ttl, $callback, $store = null)
    {
        $key = is_array($key) ? implode('.', $key) : $key;

        return cache()->store($store)->remember($key, $ttl, $callback);
    }
}
