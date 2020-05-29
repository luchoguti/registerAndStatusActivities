<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activities;
use Faker\Generator as Faker;

$factory->define(Activities::class, function (Faker $faker) {
    return array(
        'name'=>$faker->text (30),
        'status'=>$faker->numberBetween (1,2),
        'date_execute'=>$faker->dateTimeBetween('-4 month', '+4 month'),
        'id_employees'=>$faker->numberBetween (1,30),
    );
});
