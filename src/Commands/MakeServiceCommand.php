<?php

namespace Whyl\ApiScaffolder\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeServiceCommand extends GeneratorCommand
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';
    protected $type = 'Service';

    protected function getStub()
    {
        return $this->resolveStubPath(__DIR__ . '/../stubs/service.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath('stubs/service.stub'))
            ? $customPath
            : $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }
}
