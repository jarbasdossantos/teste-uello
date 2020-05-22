<?php

namespace Jarbas\Routes\ServiceProviders;

use Jarbas\Routes\Uello;

use Illuminate\Support\ServiceProvider;

class UelloServiceProvider extends ServiceProvider
{
    protected $defer = false;
    
    public function register()
    {
        return $this->app->bind('Uello', function () {
            return new Uello;
        });
    }
    
    public function boot()
    {
    }
}
