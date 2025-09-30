<?php

namespace Whyl\ApiScaffolder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallServiceCommand extends Command
{
    protected $signature = 'service:install';
    protected $description = 'Installs the base Service class';

    public function handle()
    {
        $path = app_path('Http/Services');
        $file = $path . '/Service.php';

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
            $this->info("Directory created: {$path}");
        }

        $content = file_get_contents(__DIR__.'/../stubs/service.base.stub');

        File::put($file, $content);

        $this->info("Base Service class installed successfully: {$file}");
    }
}
