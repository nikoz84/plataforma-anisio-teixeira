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
        'password' => '123456',
        'remember_token' => null,
        'options' => [],
        'verification_token' => null, 
        'verified' => false,
        'created_at' => $faker->date(),
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
        'created_at' => $faker->date()  
    ];
});
$factory->define(App\Tag::class, function(Faker $faker){
    return [
        'name' => $faker->unique()->word . rand(1, 100),
        'searched' => $faker->numberBetween(0, 2500),
        'created_at' => $faker->date()  
    ];
});
$factory->define(App\Category::class, function(Faker $faker){
    $canal_id = (isset($attribues['id'])) ?: App\Canal::all()->random()->id;

    return [
        'parent_id' => null,
        'name' => $faker->word,
        'canal_id' => $canal_id,
        'options' => [],
        'created_at' => $faker->date()  
    ];
});

$factory->define(App\Conteudo::class, function (Faker $faker) {
    $canal_id = (isset($attribues['id'])) ?: App\Canal::all()->random()->id;
    $approving_user_id = (isset($attribues['id'])) ?: App\User::all()->random()->id;
    $user_id = (isset($attribues['id'])) ?: App\User::all()->random()->id;
    $license_id = (isset($attribues['id'])) ?: App\License::all()->random()->id;
    $category_id = (isset($attribues['id'])) ?: App\Category::all()->random()->id;

    return [
        'user_id' => $user_id, 
        'approving_user_id' => $approving_user_id, 
        'license_id' => $license_id, 
        'category_id' => $category_id,
        'canal_id'  => $canal_id,
        'title' => $faker->sentence(rand(6, 15), true),
        'description' => $faker->text(250),
        'authors' => "{$faker->firstName} {$faker->LastName}", 
        'source' =>  "{$faker->firstName} {$faker->LastName}",
        'is_approved' => $faker->boolean, 
        'is_site' => $faker->boolean,
        'qt_downloads' => $faker->numberBetween(0, 9000),
        'qt_access' => $faker->numberBetween(0, 5000),
        'options' => '{}',
        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
    
});

