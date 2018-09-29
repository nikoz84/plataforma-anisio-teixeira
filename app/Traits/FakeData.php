<?php 
namespace App\Traits;

trait FakeData {

    static function getData() {
        return [
            'users'=>[
                [
                    'id' => 1,
                    'name' => str_random(10),
                    'email' => str_random(10).'@gmail.com',
                    'password' => bcrypt('secret'),
                ],
                [
                    'id' => 2,
                    'name' => str_random(10),
                    'email' => str_random(10).'@gmail.com',
                    'password' => bcrypt('secret'),
                ],
                [
                    'id' => 3,
                    'name' => str_random(10),
                    'email' => str_random(10).'@gmail.com',
                    'password' => bcrypt('secret'),
                ]
            ],
            'canais'=>[
                [
                    
                    'name'=> 'Emitec',
                    'description' => str_random(60),
                    'is_active' => true,
                    'slug' => 'emitec'
                ],
                [
                    
                    'name'=> 'Tv Anísio Teixera', 
                    'description' => str_random(60), 
                    'is_active'=> true, 
                    'slug' => 'tv-anisio-teixeira'
                ],
                [
                    
                    'name'=> 'Plataforma Anísio Teixeira', 
                    'description' => str_random(60), 
                    'is_active'=> true, 
                    'slug' => 'plataforma-anisio-teixeira'
                ]
            ],
            'conteudos'=>[
                [
                    'canal_id' => 1, 
                    'user_id' => 2,
                    'title'=> str_random(10), 
                    'description'=> str_random(60),
                    'autores'=> str_random(10), 
                    'fonte'=> str_random(15),
                    'is_featured'=> true, 
                    'is_approved' => true, 
                    'options' => '{"tags":[1,2,3]}'
                ],
                [
                    'canal_id' => 2, 
                    'user_id' => 3,
                    'title'=> str_random(10), 
                    'description'=> str_random(60),
                    'autores'=> str_random(10), 
                    'fonte'=> str_random(15), 
                    'is_featured'=> false, 
                    'is_approved' => true, 
                    'options' => '{"tags":[1,3,5]}'
                ],
                [
                    'canal_id' => 1, 
                    'user_id' => 1,
                    'title'=> str_random(10), 
                    'description'=> str_random(60),
                    'autores'=> str_random(10), 
                    'fonte'=> str_random(15), 
                    'is_featured'=> false, 
                    'is_approved' => true, 
                    'options' => '{"tags":[1,6]}'
                ],
                [
                    'canal_id' => 1, 
                    'user_id' => 1,
                    'title'=> str_random(10), 
                    'description'=> str_random(60),
                    'autores'=> str_random(10), 
                    'fonte'=> str_random(15), 
                    'is_featured'=> false, 
                    'is_approved' => true, 
                    'options' => '{"tags":[3,4]}'
                ],
                [
                    'canal_id' => 3, 
                    'user_id' => 2,
                    'title'=> str_random(10), 
                    'description'=> str_random(60),
                    'autores'=> str_random(10), 
                    'fonte'=> str_random(15), 
                    'is_featured'=> false, 
                    'is_approved' => true, 
                    'options' => '{"tags":[5,6]}'
                ],
                [
                    'canal_id' => 3, 
                    'user_id' => 1,
                    'title'=> str_random(10), 
                    'description'=> str_random(60),
                    'autores'=> str_random(10), 
                    'fonte'=> str_random(15), 
                    'is_featured'=> false, 
                    'is_approved' => true, 
                    'options' => '{"tags":[6,4]}'
                ]
        
            ],
            'aplicativos'=> [
                [
                    'user_id'=> 1,
                    'name'=> str_random(10),
                    'description'=> str_random(60),
                    'is_featured'=> true
                ],
                [
                    'user_id'=> 2,
                    'name'=> str_random(10),
                    'description'=> str_random(60),
                    'is_featured'=> false
                ],
                [
                    'user_id'=> 2,
                    'name'=> str_random(10),
                    'description'=> str_random(60),
                    'is_featured'=> false
                ],
                [
                    'user_id'=> 1,
                    'name'=> str_random(10),
                    'description'=> str_random(60),
                    'is_featured'=> false
                ],
                [
                    'user_id'=> 3,
                    'name'=> str_random(10),
                    'description'=> str_random(60),
                    'is_featured'=> false
                ]
            ],
            'tags' => [
                [
                    'name'=> str_random(5),
                    'searched'=> rand(10,100)
                ],
                [
                    'name'=> str_random(5),
                    'searched'=> rand(10,100)
                ],
                [
                    'name'=> str_random(5),
                    'searched'=> rand(10,100)
                ],
                [
                    'name'=> str_random(5),
                    'searched'=> rand(10,100)
                ],
                [
                    'name'=> str_random(5),
                    'searched'=> rand(10,100)
                ],
                [
                    'name'=> str_random(5),
                    'searched'=> rand(10,100)
                ]
            ]    
        ];
    }



}