<?php

namespace Whyl\ApiScaffolder\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeRepositoryCommand extends GeneratorCommand
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Create a new repository class';
    protected $type = 'Repository';

    protected function getStub()
    {
        return $this->resolveStubPath(__DIR__ . '/../stubs/repository.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath('stubs/repository.stub'))
            ? $customPath
            : $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Repositories';
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $model = $this->getModelName($name);
        return str_replace('{{ model }}', $model, $stub);
    }

    protected function getModelName($name)
    {
        return str_replace('Repository', '', class_basename($name));
    }
}
