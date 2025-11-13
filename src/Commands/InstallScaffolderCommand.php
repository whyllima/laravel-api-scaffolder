<?php

namespace Whyl\ApiScaffolder\Commands;

use Illuminate\Console\Command;

class InstallScaffolderCommand extends Command
{
    protected $signature = 'scaffolder:install {--force : Overwrite existing files}';
    protected $description = 'Install all Laravel API Scaffolder components (Repositories, Services, and Resources)';

    public function handle()
    {
        $this->info('╔══════════════════════════════════════════════════════════════╗');
        $this->info('║           Laravel API Scaffolder - Installation             ║');
        $this->info('╚══════════════════════════════════════════════════════════════╝');
        $this->newLine();

        // Install Repositories
        $this->info('📁 Installing Base Repository...');
        $this->call('repository:install');
        $this->newLine();

        // Install Services
        $this->info('⚙️  Installing Base Service...');
        $this->call('service:install');
        $this->newLine();

        // Install Resources
        $this->info('📦 Installing Base Resources...');
        $this->call('resource:install');
        $this->newLine();

        // Success message
        $this->info('╔══════════════════════════════════════════════════════════════╗');
        $this->info('║                 ✅ Installation Complete!                    ║');
        $this->info('╚══════════════════════════════════════════════════════════════╝');
        $this->newLine();

        // Display next steps
        $this->comment('📝 Next steps:');
        $this->newLine();
        $this->line('   1. Start creating your APIs:');
        $this->line('      • php artisan make:repository UserRepository');
        $this->line('      • php artisan make:service UserService');
        $this->newLine();
        
        $this->line('   2. Use the generic filters in your repositories:');
        $this->line('      • ?per_page=20');
        $this->line('      • ?status=active');
        $this->line('      • ?created_at=01/01/2024,31/12/2024');
        $this->line('      • ?sort=recent');
        $this->newLine();

        $this->line('   3. Your API responses are now standardized:');
        $this->line('      • Success: {"status": "success", ...}');
        $this->line('      • Error: {"status": "error", "message": "..."}');
        $this->newLine();

        $this->info('📚 Documentation: https://github.com/whyllima/laravel-api-scaffolder');
        $this->newLine();

        return self::SUCCESS;
    }
}

