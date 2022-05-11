<?php

use Jenssegers\Agent\Agent;

if (!function_exists('agent_user_info')) {
    function agent_user_info()
    {
        $agent = new Agent();
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $browser_version = $agent->version($browser);
        $is_phone=$agent->isPhone();
        $is_robot=$agent->isRobot();

        return $platform .','.$device . ','. $browser .$browser_version. ','. $is_phone . ','.$is_robot;
    }
}
