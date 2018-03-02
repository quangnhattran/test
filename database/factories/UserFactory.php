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
$factory->state(App\User::class,'administrator',function(){
    return [
        'name' => 'QT'
    ];
});

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Thread::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'title'=>$title,
        'slug' => str_slug($title),
        'body'=>$faker->paragraph,
        'user_id'=> function() {
            return factory('App\User')->create()->id;
        },
        'channel_id'=> function() {
            return factory('App\Channel')->create()->id;
        },
        'locked' => false
    ];
});

$factory->define(App\Channel::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => str_slug($name)
    ];
});

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'body'=>$faker->paragraph,
        'user_id'=> function() {
            return factory('App\User')->create()->id;
        },
        'thread_id'=> function() {
            return factory('App\Thread')->create()->id;
        },
    ];
});
