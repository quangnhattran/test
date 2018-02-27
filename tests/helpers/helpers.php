<?php

if(! function_exists('create_admin')) {
    function create_admin() 
    {
        factory('App\User')->create([
            'name'=>'QT',
            'email'=>'quangvision@gmail.com',
            'password'=>bcrypt('secret')
        ]);
    }
}