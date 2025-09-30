<?php

namespace Whyl\ApiScaffolder;

use Illuminate\Support\ServiceProvider;
use Whyl\ApiScaffolder\Commands\InstallRepositoryCommand;
use Whyl\ApiScaffolder\Commands\InstallServiceCommand;
use Whyl\ApiScaffolder\Commands\MakeRepositoryCommand;
use Whyl\ApiScaffolder\Commands\MakeServiceCommand;

class ApiScaffolderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallRepositoryCommand::class,
                InstallServiceCommand::class,
                MakeRepositoryCommand::class,
                MakeServiceCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/stubs/repository.stub' => $this->app->basePath('stubs/repository.stub'),
            __DIR__.'/stubs/service.stub' => $this->app->basePath('stubs/service.stub'),
        ], 'stubs');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
