<?php

namespace Database\Seeders;

use App\Models\Ip;
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
        \App\Models\Statistic::factory(10)->create();
    }
}
