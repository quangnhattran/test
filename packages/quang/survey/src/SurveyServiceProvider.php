<?php
namespace Survey;

use Illuminate\Support\ServiceProvider;


class SurveyServiceProvider extends ServiceProvider 
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        
    }

    public function register()
    {
        
    }
}