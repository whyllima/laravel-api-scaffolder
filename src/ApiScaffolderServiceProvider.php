<?php

namespace Whyl\ApiScaffolder;

use Illuminate\Support\ServiceProvider;
use Whyl\ApiScaffolder\Commands\InstallRepositoryCommand;
use Whyl\ApiScaffolder\Commands\InstallResourceCommand;
use Whyl\ApiScaffolder\Commands\InstallScaffolderCommand;
use Whyl\ApiScaffolder\Commands\InstallServiceCommand;
use Whyl\ApiScaffolder\Commands\MakeRepositoryCommand;
use Whyl\ApiScaffolder\Commands\MakeServiceCommand;

class ApiScaffolderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallScaffolderCommand::class,
                InstallRepositoryCommand::class,
                InstallResourceCommand::class,
                InstallServiceCommand::class,
                MakeRepositoryCommand::class,
                MakeServiceCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/stubs/repository.stub' => $this->app->basePath('stubs/repository.stub'),
            __DIR__ . '/stubs/service.stub' => $this->app->basePath('stubs/service.stub'),
            __DIR__ . '/stubs/resource.stub' => $this->app->basePath('stubs/resource.stub'),
            __DIR__ . '/stubs/error-resource.stub' => $this->app->basePath('stubs/error-resource.stub'),
            __DIR__ . '/stubs/resource-collection.stub' => $this->app->basePath('stubs/resource-collection.stub'),
        ], 'stubs');
    }

    public function register()
    {
        //
    }
}
