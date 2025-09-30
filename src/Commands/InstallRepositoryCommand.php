<?php

namespace Whyl\ApiScaffolder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallRepositoryCommand extends Command
{
    protected $signature = 'repository:install';
    protected $description = 'Installs the base Repository class';

    public function handle()
    {
        $path = app_path('Http/Repositories');
        $file = $path . '/Repository.php';

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
            $this->info("Directory created: {$path}");
        }

        $content = file_get_contents(__DIR__.'/../stubs/repository.base.stub');

        File::put($file, $content);

        $this->info("Base Repository class installed successfully: {$file}");
    }
}
