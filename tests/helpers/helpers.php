<?php

if(! function_exists('create_admin')) {
    function create_admin() 
    {
        factory('App\User')->create([
            'name'=>'QT',
            'confirmed'=>true,
            'email'=>'quangvision@gmail.com',
            'password'=>bcrypt('secret')
        ]);
    }
}

function create($class,$attributes=[],$times=null)
{
    return factory($class,$times)->create($attributes);
}

function make($class,$attributes=[],$times=null)
{
    return factory($class,$times)->make($attributes);
}