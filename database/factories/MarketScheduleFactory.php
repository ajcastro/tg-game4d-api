<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Market;
use App\Models\MarketSchedule;
use App\Models\User;

class MarketScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MarketSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'market_id' => Market::factory(),
            'result_day' => '{}',
            'is_result_day_everyday' => $this->faker->boolean,
            'off_day' => '{}',
            'is_off_day_everyday' => $this->faker->boolean,
            'close_time' => $this->faker->word,
            'result_time' => $this->faker->word,
            'updated_by_id' => User::factory(),
        ];
    }
}
