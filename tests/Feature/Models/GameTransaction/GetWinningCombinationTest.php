<?php

namespace Tests\Feature\Models\GameTransaction;

use App\Models\Game;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetWinningCombinationTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_winning_combination()
    {
        /** @var Game */
        $game = Game::factory()->create([
            'market_result' => '1234',
        ]);

        $this->assertEquals([
            'num1' => 1,
            'num2' => 2,
            'num3' => 3,
            'num4' => 4,
        ], $game->getWinningCombination('4D'));

        $this->assertEquals([
            'num2' => 2,
            'num3' => 3,
            'num4' => 4,
        ], $game->getWinningCombination('3D'));

        $this->assertEquals([
            'num3' => 3,
            'num4' => 4,
        ], $game->getWinningCombination('2D'));

        $this->assertEquals([
            'num2' => 2,
            'num3' => 3,
        ], $game->getWinningCombination('2DT'));

        $this->assertEquals([
            'num1' => 1,
            'num2' => 2,
        ], $game->getWinningCombination('2DD'));
    }
}
