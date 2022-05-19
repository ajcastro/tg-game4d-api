<?php

namespace App\Jobs;

use App\Models\Game;
use App\Models\GameTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GameTransactionsSetWinningStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Game $game;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $game_codes = [
            '4D', '3D', '2D', '2DT', '2DD',
        ];

        foreach ($game_codes as $game_code) {
            GameTransaction::loserFor($this->game, $game_code, $this->game->getWinningCombination($game_code))
                ->update(['status' => 0]);

            $winners = GameTransaction::winnerFor($this->game, $game_code, $this->game->getWinningCombination($game_code))
                ->get();

            foreach ($winners as $winner) {
                /** @var GameTransaction $winner */
                $winner->winning_amount = $winner->computeWinningAmount();
                $winner->save();
            }
        }
    }
}
