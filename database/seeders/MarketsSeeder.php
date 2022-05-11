<?php

namespace Database\Seeders;

use App\Models\Market;
use App\Models\MarketSchedule;
use App\Models\Website;
use Illuminate\Database\Seeder;

class MarketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Market::truncate();

        if (Market::query()->count() > 0) {
            return;
        }

        $rows = [
            [
                'code' => 'TKY',
                'name' => 'Tokyo',
            ],
            [
                'code' => 'SOL',
                'name' => 'Seoul',
            ],
            [
                'code' => 'SGP',
                'name' => 'Singapore',
            ],
            [
                'code' => 'MNL',
                'name' => 'Manila',
            ],
            [
                'code' => 'BCL',
                'name' => 'Barcelona',
            ],
            [
                'code' => 'HK',
                'name' => 'HongKong',
            ],
            [
                'code' => 'BK',
                'name' => 'Bangkok',
            ],
            [
                'code' => 'MIL',
                'name' => 'Milan',
            ],
            [
                'code' => 'BEI',
                'name' => 'Beijing',
            ],
            [
                'code' => 'LGP',
                'name' => 'Legazpi',
            ],
        ];


        $markets = collect($rows)->map(function ($row) {
            return Market::firstOrCreate([
                'code' => $row['code']
            ], $row+['status' => collect(['online', 'offline'])->random()]);
        });

        foreach ($markets as $market) {
            $marketSchedule = $market->marketSchedule->fill([
                'result_day' => MarketSchedule::DAYS,
                'off_day' => [],
                'close_time' => '22:00',
                'result_time' => '23:00',
            ]);

            $marketSchedule->save();
        }
    }
}
