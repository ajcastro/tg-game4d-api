<?php

if (!function_exists('l')) {
    function l(...$params)
    {
        foreach ($params as $param) {
            logger($param);
        }
    }
}
