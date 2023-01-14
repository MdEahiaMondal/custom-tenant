<?php

namespace App\Console\Commands\RootApp;

use App\Models\Tenant;
use App\Service\TenantService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'root:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'root app migration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        TenantService::switchToDefault();
        Artisan::call('migrate --path=database/migrations/root/  --database=root_app');
        $this->info(Artisan::output());
        return Command::SUCCESS;
    }
}
