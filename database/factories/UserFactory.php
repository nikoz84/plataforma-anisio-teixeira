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
        'options' => [],
        'verification_token' => null, 
        'verified' => false,
        'created_at' => $faker->unique()->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
        'updated_at' => $faker->unique()->dateTimeBetween($startDate = '-30 years', $endDate = 'now')
    ];
});
$factory->define(App\License::class, function(Faker $faker){
    return [
        'name' => $faker->word,
        'description' => $faker->text(150),
        'site' => $faker->url(),
        'created_at' => $faker->unique()->dateTimeBetween($startDate = '-5 years', $endDate = 'now')
    ];
});
$factory->define(App\Canal::class, function(Faker $faker){
    return [
        'name' => $faker->word,
        'description' => $faker->text(200),
        'slug' => $faker->slug,
        'is_active' => $faker->boolean,
        'options' => [],
        'created_at' => $faker->unique()->dateTimeBetween($startDate = '-10 years', $endDate = 'now')    
    ];
});
$factory->define(App\Conteudo::class, function (Faker $faker) {
    return [
        'user_id' => range(1,3), 
        'approving_user_id' => range(1,2), 
        'license_id' => range(1,3), 
        'category_id' => null,
        'canal_id'  => range(1,3),
        'title' => $faker->title,
        'description' => $faker->text(250),
        'authors' => $faker->name, 
        'source' =>  $faker->name,
        'is_approved' => $faker->boolean, 
        'is_site' => $faker->boolean,
        'qt_downloads' => $faker->numberBetween($min = 0, $max = 9000),
        'qt_access' => $faker->numberBetween($min = 0, $max = 5000),
        'options' => [],
        'created_at' => $faker->unique()->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
        'updated_at' => $faker->unique()->dateTimeBetween($startDate = '-30 years', $endDate = 'now')
    ];
    
});
