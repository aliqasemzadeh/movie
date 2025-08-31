<?php

namespace App\Console\Commands\System\Install;

use App\Console\Commands\System\Administrator\CreateAdminCommand;
use App\Console\Commands\System\Administrator\CreatePermissionsCommand;
use App\Console\Commands\System\Administrator\CreateRolesCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class QuickSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:install.quick-setup-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Quick Setup Command');
        $this->info('Creating Roles, Permissions and Admin');
        $this->info('Create Roles');
        Artisan::call(CreateRolesCommand::class);
        $this->info('Create Permissions');
        Artisan::call(CreatePermissionsCommand::class);
        $this->info('Create Administration');
        Artisan::call(CreateAdminCommand::class);
    }
}
