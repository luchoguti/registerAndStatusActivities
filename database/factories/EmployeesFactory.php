<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employees;
use Faker\Generator as Faker;

$factory->define(Employees::class, function (Faker $faker) {
    return [
        'first_name'=>$faker->text ('10'),
        'second_name'=> $faker->text ('10'),
        'type_identification'=> $faker->numberBetween (1,3),
        'number_identification' => $faker->randomNumber (9),
        'id_job_area'=>$faker->numberBetween(1,5)
    ];
});
