<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Game;
use App\Models\GameEdit;
use App\Models\User;

class GameEditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameEdit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'game_id' => Game::factory(),
            'edit_field' => $this->faker->word,
            'date' => $this->faker->date(),
            'close_time' => $this->faker->word,
            'market_result' => $this->faker->word,
            'created_by_id' => User::factory(),
            'approved_by_id' => User::factory(),
        ];
    }
}
