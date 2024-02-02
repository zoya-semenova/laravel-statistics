<?php

namespace Database\Seeders;

use App\Models\Ip;
use App\Models\Visit;
use Database\Factories\VisitFactory;
use Faker\Container\Container;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Question\Question;

class VisitSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $start = microtime(true);
        //echo $ip = Ip::inRandomOrder()->first()->id;
        $ip = collect(DB::select('SELECT ip FROM ips TABLESAMPLE SYSTEM_ROWS(1);'))->first()->ip;
        $timer = microtime(true) - $start;
        //$ips= collect(Ip::all()->modelKeys());
        $data = [];

        for ($i = 0; $i < 30000; $i++) {
            $chunk = [];
            for ($j = 0; $j < 10000; $j++) {
                $start = $faker->dateTimeInInterval('-1 years', '+1 years');
                $end = $faker->dateTimeInInterval($start, '+60 minutes');
                $ip = collect(DB::select('SELECT id, ip FROM ips TABLESAMPLE SYSTEM_ROWS(1);'))->first();
                $chunk[] = [
                    'start_time' => $start,
                    'end_time' => $end,
                    'ip_id' => $ip->id,
                    //'ip_id' => Ip::all()->random()->id,
                    //'ip_id' => $ips->random(),
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }
            Visit::insert($chunk);
        }
    }
}
