<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::firstOrCreate([
            'username' => 'admin',
        ], [
            'password' => bcrypt('password'),
            'name' => 'Admin',
            'is_admin' => true,
        ]);

        \App\Models\User::firstOrCreate([
            'username' => 'user',
        ], [
            'password' => bcrypt('password'),
            'name' => 'User',
        ]);

        $this->call(MarketsSeeder::class);
    }
}
