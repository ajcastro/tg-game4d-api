<?php

if (!function_exists('boolean')) {
    function boolean($bool)
    {
        return filter_var($bool, FILTER_VALIDATE_BOOLEAN);
    }
}
