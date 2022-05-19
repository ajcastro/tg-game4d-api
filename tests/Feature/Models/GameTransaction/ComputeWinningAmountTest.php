<?php

namespace Tests\Feature\Models\GameTransaction;

use App\Models\Game;
use App\Models\GameTransaction;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComputeWinningAmountTest extends TestCase
{
    use RefreshDatabase;

    public function test_computeWinningAmount()
    {
        $member = Member::factory()->create();
        /** @var Game */
        $game = Game::factory()->create([
            'market_result' => '1234',
        ]);

        /** @var GameTransaction */
        $gameTransaction = GameTransaction::create([
            'game_id' => $game->id,
            'member_id' => $member->id,
            'game_code' => '4D',
            'num1' => 1,
            'num2' => 2,
            'num3' => 3,
            'num4' => 4,
            'bet' => 1000,
            'game_setting' => [
                'limit' => 1000,
                'max_bet' => 1000000,
                'min_bet' => 1000,
                'limit_total' => 3000,
                'percentage_kei' => 0,
                'win_multiplier' => 30,
                'percentage_discount' => 50
            ]
        ]);

        $this->assertEquals(1000 * (30/100), $gameTransaction->computeWinningAmount());
    }
}
