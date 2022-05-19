<?php

namespace Tests\Feature\Models\GameTransaction;

use App\Models\Game;
use App\Models\GameTransaction;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WinnerForTest extends TestCase
{
    use RefreshDatabase;

    public function test_winner_for_4D()
    {
        /** @var Game */
        $game = Game::factory()->create([
            'market_result' => '1234',
        ]);
        $game_code = '4D';

        $query = GameTransaction::winnerFor($game, $game_code, $game->getWinningCombination($game_code));

        $this->assertEquals(
            'select * from `game_transactions` where `game_id` = ? and `game_code` = ? and '
            .'(`num1` = ? and `num2` = ? and `num3` = ? and `num4` = ?)',
            $query->toSql()
        );

        $this->assertEquals([
            $game->id,
            $game_code,
            '1',
            '2',
            '3',
            '4',
        ], $query->getBindings());
    }

    public function test_winner_for_3D()
    {
        /** @var Game */
        $game = Game::factory()->create([
            'market_result' => '1234',
        ]);

        $game_code = '3D';

        $query = GameTransaction::winnerFor($game, $game_code, $game->getWinningCombination($game_code));

        $this->assertEquals(
            'select * from `game_transactions` where `game_id` = ? and `game_code` = ? and '
            .'(`num2` = ? and `num3` = ? and `num4` = ?)',
            $query->toSql()
        );

        $this->assertEquals([
            $game->id,
            $game_code,
            '2',
            '3',
            '4',
        ], $query->getBindings());
    }

    public function test_winner_for_2D()
    {
        /** @var Game */
        $game = Game::factory()->create([
            'market_result' => '1234',
        ]);

        $game_code = '2D';

        $query = GameTransaction::winnerFor($game, $game_code, $game->getWinningCombination($game_code));

        $this->assertEquals(
            'select * from `game_transactions` where `game_id` = ? and `game_code` = ? and '
            .'(`num3` = ? and `num4` = ?)',
            $query->toSql()
        );

        $this->assertEquals([
            $game->id,
            $game_code,
            '3',
            '4',
        ], $query->getBindings());
    }

    public function test_winner_for_2DT()
    {
        /** @var Game */
        $game = Game::factory()->create([
            'market_result' => '1234',
        ]);

        $game_code = '2DT';

        $query = GameTransaction::winnerFor($game, $game_code, $game->getWinningCombination($game_code));

        $this->assertEquals(
            'select * from `game_transactions` where `game_id` = ? and `game_code` = ? and '
            .'(`num2` = ? and `num3` = ?)',
            $query->toSql()
        );

        $this->assertEquals([
            $game->id,
            $game_code,
            '2',
            '3',
        ], $query->getBindings());
    }

    public function test_winner_for_2DD()
    {
        /** @var Game */
        $game = Game::factory()->create([
            'market_result' => '1234',
        ]);

        $game_code = '2DD';

        $query = GameTransaction::winnerFor($game, $game_code, $game->getWinningCombination($game_code));

        $this->assertEquals(
            'select * from `game_transactions` where `game_id` = ? and `game_code` = ? and '
            .'(`num1` = ? and `num2` = ?)',
            $query->toSql()
        );

        $this->assertEquals([
            $game->id,
            $game_code,
            '1',
            '2',
        ], $query->getBindings());
    }
}
