<?php

if (!function_exists('is_using')) {
    function is_using($class, $trait)
    {
        $traits = class_uses_recursive($class);

        return isset($traits[$trait]);
    }
}
