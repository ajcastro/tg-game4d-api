<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Game;
use App\Models\GameTransaction;
use App\Models\Member;

class GameTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'game_id' => Game::factory(),
            'member_id' => Member::factory(),
            'game_code' => $this->faker->word,
            'num1' => $this->faker->randomDigitNotNull,
            'num2' => $this->faker->randomDigitNotNull,
            'num3' => $this->faker->randomDigitNotNull,
            'num4' => $this->faker->randomDigitNotNull,
            'bet' => $this->faker->randomFloat(2, 0, 9999999999999.99),
            'discount' => $this->faker->randomFloat(2, 0, 9999999999999.99),
            'pay' => $this->faker->randomFloat(2, 0, 9999999999999.99),
            'game_setting' => '{}',
            'status' => $this->faker->randomDigitNotNull,
            'winning_amount' => $this->faker->randomFloat(2, 0, 9999999999999.99),
            'credit_amount' => $this->faker->randomFloat(2, 0, 9999999999999.99),
        ];
    }
}
