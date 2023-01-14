<?php

namespace App\Console\Commands\Tenants;

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
    protected $signature = 'tenant:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tenants = Tenant::all();
        $tenants->each(function ($tenant) {
            TenantService::switchToTenant($tenant);
            $this->info('Start migrating : ' . $tenant->domain);
            $this->info('---------------------------------------');
            Artisan::call('migrate --path=database/migrations/tenants/  --database=tenancy');
            $this->info(Artisan::output());
        });
        return Command::SUCCESS;
    }
}
