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
            'game_set' => 'required',
        ]);

        if ($request->game_set === '4D/3D/2D') {
            return GameSetting::getGameSettingsFor4D3D2D(auth()->user()->website_code);
        }

        return abort(404, 'No game settings found.');
    }
}
