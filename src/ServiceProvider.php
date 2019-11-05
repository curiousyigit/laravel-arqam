<?php

namespace hopefeda\LaravelArqam;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot() 
    {
        $this->publishes([__DIR__.'/config/arqam.php' => config_path('arqam.php')]);
    }
    
    public function register() 
    {
        $this->mergeConfigFrom(__DIR__.'/config/arqam.php', 'arqam');
        $this->app->bind('Arqam', function($app)
        {
            return $this->app->make('hopefeda\LaravelArqam\Arqam');
        });
    }
}

