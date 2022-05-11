<?php

if (!function_exists('ddr')) {
    /**
     * Dump-die-readable.
     *
     * @param mixed $data
     */
    function ddr($data)
    {
        $args = array_map(function ($arg) {
            if (is_object($arg) && method_exists($arg, 'toArray')) {
                return $arg->toArray();
            }
            return $arg;
        }, func_get_args());

        call_user_func_array('dd', $args);
    }
}

if (!function_exists('dumpr')) {
    /**
     * Dump-readable.
     *
     * @param mixed $data
     */
    function dumpr($data)
    {
        $args = array_map(function ($arg) {
            if (is_object($arg) && method_exists($arg, 'toArray')) {
                return $arg->toArray();
            }
            return $arg;
        }, func_get_args());

        call_user_func_array('dump', $args);
    }
}
