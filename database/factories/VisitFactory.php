<?php

namespace Database\Factories;

use App\Models\Ip;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class VisitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = $this->faker->dateTimeInInterval('-30 days', '+30 days');
        $end = $this->faker->dateTimeInInterval($start, '+60 minutes');

        return [
            //'ip_id' => $this->faker->randomElement(Ip::pluck('id')),
            //'ip_id' => '1',
            'ip_id' => Ip::all()->random()->id,
            'start_time' => $start,
            'end_time' => $end
        ];
    }
}
