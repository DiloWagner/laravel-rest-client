<?php

namespace CursoLaravel\Providers;

use CursoLaravel\Repositories\ClientRepository;
use CursoLaravel\Repositories\ClientRepositoryEloquent;
use CursoLaravel\Repositories\ProjectNoteRepository;
use CursoLaravel\Repositories\ProjectNoteRepositoryEloquent;
use CursoLaravel\Repositories\ProjectRepository;
use CursoLaravel\Repositories\ProjectRepositoryEloquent;
use CursoLaravel\Repositories\ProjectTaskRepository;
use CursoLaravel\Repositories\ProjectTaskRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class CursoLaravelRepositoryProvider extends ServiceProvider
{
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
        $this->app->bind(ClientRepository::class, ClientRepositoryEloquent::class);
        $this->app->bind(ProjectRepository::class, ProjectRepositoryEloquent::class);
        $this->app->bind(ProjectNoteRepository::class, ProjectNoteRepositoryEloquent::class);
        $this->app->bind(ProjectTaskRepository::class, ProjectTaskRepositoryEloquent::class);
    }
}
