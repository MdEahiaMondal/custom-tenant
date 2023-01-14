<?php

namespace App\Console\Commands\RootApp;

use App\Models\Tenant;
use App\Service\TenantServcie;
use App\Service\TenantService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'root:seeder {class}';

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
        $class = $this->argument('class');
            TenantService::switchToDefault();
            $this->info('---------------------------------------');
            Artisan::call('db:seed', [
                '--class' => 'Database\\Seeders\\Root\\' . $class,
                '--database' => 'root_app'
            ]);
            $this->info(Artisan::output());
        return Command::SUCCESS;
    }
}
