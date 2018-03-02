<?php

Route::group([
    'namespace' => 'Survey\Http\Controllers',
    'prefix' => 'audit'
], function() {
    Route::get('/',function(){
        return ['hello','this is audit route'];
    });
});