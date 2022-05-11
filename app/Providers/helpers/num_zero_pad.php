<?php

if (! function_exists('num_zero_pad')) {
    function num_zero_pad($num, $length)
    {
        return str_pad($num, $length, '0', STR_PAD_LEFT);
    }
}
