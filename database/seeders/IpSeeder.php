<?php

namespace Database\Seeders;

use App\Models\Ip;
use App\Models\Visit;
use Faker\Generator;
use Illuminate\Database\Seeder;

class IpSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        /*
        for ($i=0; $i < 30; $i++) {
            \App\Models\Ip::factory(100000)->create();
        }
        */

        for ($i = 0; $i < 3000; $i++) {
            $chunk = [];
            for ($j = 0; $j < 1000; $j++) {
                $chunk[] = [
                    'ip' => $faker->ipv4(),
                    //'ip_id' => 1,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }
            Ip::insert($chunk);
        }

    }
}
