<?php

namespace Database\Seeders;

use App\Models\Ip;
use App\Models\Statistic;
use App\Models\Visit;
use Database\Factories\VisitFactory;
use Faker\Container\Container;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Question\Question;

class StatisticsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        //echo $ip = Ip::inRandomOrder()->first()->id;
        for ($i = 0; $i < 3000; $i++) {
            $chunk = [];
            for ($j = 0; $j < 1000; $j++) {
                //$date = $faker->dateTimeBetween('-1 years', '+1 years');
                $date = $faker->dateTimeThisYear();
                $time = $faker->numberBetween(0,1440);
                $ip = collect(DB::select('SELECT id, ip FROM ips TABLESAMPLE SYSTEM_ROWS(1);'))->first();
                $chunk[] = [
                    'time' => $time,
                    'date' => $date,
                    'ip_id' => $ip->id,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }
            Statistic::insert($chunk);
        }
    }
}
