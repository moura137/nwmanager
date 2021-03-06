<?php

namespace NwManager\Providers;

use Illuminate\Support\ServiceProvider;
use NwManager\Repositories\Contracts;
use NwManager\Repositories\Eloquent;

class RepositoriesServiceProvider extends ServiceProvider
{
    protected $repositories = [
        Contracts\UserRepository::class => Eloquent\UserEloquentRepository::class,
        Contracts\ClientRepository::class => Eloquent\ClientEloquentRepository::class,
        Contracts\ProjectRepository::class => Eloquent\ProjectEloquentRepository::class,
        Contracts\ProjectNoteRepository::class => Eloquent\ProjectNoteEloquentRepository::class,
        Contracts\ProjectTaskRepository::class => Eloquent\ProjectTaskEloquentRepository::class,
        Contracts\ProjectFileRepository::class => Eloquent\ProjectFileEloquentRepository::class,
        Contracts\ActivityRepository::class => Eloquent\ActivityEloquentRepository::class,
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

    /**
     * Register Contracts Repositories
     *
     * @return void
     */
    protected function registerRepositories()
    {
        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }
}
