<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\\Repository\\Interfaces\\IUserRepository', 'App\\Repository\\UserRepository');
        $this->app->bind('App\\Repository\\Interfaces\\ITransactionsRepository', 'App\\Repository\\TransactionsRepository');
    }
}
