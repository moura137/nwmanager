<?php

namespace NwManager\Providers;

use Illuminate\Support\ServiceProvider;
use NwManager\Repositories\Contracts;
use NwManager\Repositories\Eloquent;

class RepositoriesServiceProvider extends ServiceProvider
{
    protected $repositories = [
        Contracts\ClientRepository::class => Eloquent\ClientEloquentRepository::class
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
    }

    protected function registerRepositories()
    {
        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
