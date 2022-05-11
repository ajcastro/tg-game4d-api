<?php

use Illuminate\Support\Carbon;

if (!function_exists('carbon')) {
    function carbon($time, $tz = null)
    {
        return Carbon::parse($time, $tz);
    }
}
