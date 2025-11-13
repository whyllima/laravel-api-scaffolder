<?php

namespace Whyl\ApiScaffolder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallResourceCommand extends Command
{
    protected $signature = 'resource:install';
    protected $description = 'Installs the base Resource classes (Resource, ErrorResource, ResourceCollection)';

    public function handle()
    {
        $path = app_path('Http/Resources');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
            $this->info("Directory created: {$path}");
        }

        $resources = [
            'resource.stub' => 'Resource.php',
            'error-resource.stub' => 'ErrorResource.php',
            'resource-collection.stub' => 'ResourceCollection.php'
        ];

        foreach ($resources as $stub => $filename) {
            $file = $path . '/' . $filename;
            $content = file_get_contents(__DIR__.'/../stubs/'.$stub);
            File::put($file, $content);
            $this->info("✓ {$filename} installed successfully");
        }

        $this->info("\nAll base Resource classes installed successfully in: {$path}");
    }
}

