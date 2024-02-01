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
//        echo "<pre>";print_r($ip);exit;
//        echo "<pre>";print_r($timer);exit;
//        exit;
/*
        for ($i=0; $i < 900; $i++) {
            \App\Models\Visit::factory(100000)->create();
        }
*/
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
                    //'ip_id' => 1,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }
            Visit::insert($chunk);
        }
/*
        $chunks = array_chunk($data, 10000);

        foreach ($chunks as $chunk) {
            Visit::insert($chunk);
        }
*/

/*
        for ($i=0; $i < 10; $i++) {
            $posts = Visit::factory()->count(1)->create();
            //$posts = VisitFactory::factoryForModel(Visit::class)->count(10)->create();

            $chunks = $posts->chunk(1);

            $chunks->each(function ($chunk) {
                Visit::insert($chunk->toArray());
            });
    }
*/
        /*
        $accounts = User::query()->pluck('id');
        $faker = Container::getInstance()->make(Generator::class);
        $ownProductId = $faker->regexify('[LD0-9]{1}[A-Z0-9]{9}');
        $data = [];

        for($i=0; $i< 320; $i++) {
            for($v=0; $v< 50000; $v++) {
                $data[] = [
                    'createdAt'       => (int)date('U'),
                    'productId'       => $ownProductId,
                    'title'           => $faker->sentence(3),
                    'imageUrl'        => '',
                    'User_id'         => $accounts->random(),
                    'productIds'      => implode(',', $this->generateFakeProductIds($ownProductId)),
                    'parentProductId' => $faker->regexify('[LD0-9]{1}[A-Z0-9]{9}'),
                    'status' => $faker->randomElement(StatusesEnum::cases()),
                    'searchType'      => $faker->randomElement(SearchTypesEnum::cases()),
                    'url'             => Str::random(50),
                    'marketplace'     => $faker->randomElement(array_keys(MarketplacesConfigService::CONFIGS)),
                ];

            }

            $chunks = array_chunk($data, 5000);
            foreach ($chunks as $chunk) {
                TestModel::query()->insert($chunk);
            }
        }
/*

        $users = Visit::factory()->count(100000)->make();
        $chunks = $users->chunk(10);

        for($i = 0; $i< 10000; $i++){
            $usersTemp = $chunks->get($i);

            foreach ($usersTemp as $user){
                $user->ip_id =$i+1;
            }
        }
        $chunks = $users->chunk(2000);

        $chunks->each(function($chunk){
            Visit::insert($chunk->toArray());
        });
*/
    }
}
