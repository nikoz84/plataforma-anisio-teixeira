<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'options' => '[]',
        'verification_token' => null, 
        'verified' => false,
        'created_at' => $faker->unique()->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
        'updated_at' => $faker->unique()->dateTimeBetween($startDate = '-30 years', $endDate = 'now')
    ];
});

$factory->define(App\Conteudo::class, function (Faker $faker) {
    return [
        'user_id' => numberBetween($min = 1000, $max = 9000) 
        'approving_user_id' => , 
        'license_id' => , 
        'category_id' => ,
        'canal_id'  => ,
        'title' => $faker->title,
        'description' => $faker->text(250),
        'authors' => $faker->name, 
        'source' =>  
'is_aproved' 
is_site
qt_downloads
qt_access
options
created_at
        'created_at' => $faker->unique()->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
        'updated_at' => $faker->unique()->dateTimeBetween($startDate = '-30 years', $endDate = 'now')
    ];
});
