<?php

namespace App\Http\Controllers\Api\Gamesite;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Services\Telegaming\GameSetting;
use Illuminate\Http\Request;

class GameSettingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'game_code' => 'required',
        ]);

        return GameSetting::getSetting(auth()->user()->website_code, $request->game_code);
    }
}
