<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Game;
use App\Models\Market;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'market_id' => Market::factory(),
            'date' => $this->faker->date(),
            'period' => $this->faker->randomNumber(),
            'close_time' => $this->faker->dateTime(),
            'result_time' => $this->faker->dateTime(),
            'market_result' => $this->faker->word,
            'result_day' => $this->faker->randomDigitNotNull,
        ];
    }

    public function open()
    {
        return $this->state(function (array $attributes) {
            return [
                'market_result' => null,
            ];
        });
    }
}
