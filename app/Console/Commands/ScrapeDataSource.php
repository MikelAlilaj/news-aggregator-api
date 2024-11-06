<?php

namespace App\Console\Commands;

use App\Models\DataSource;
use Illuminate\Console\Command;
use App\Jobs\ScrapeDataSourceJob;

class ScrapeDataSource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:data-source {service}';
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
        $serviceName = $this->argument('service');

        $dataSource = DataSource::byServiceKey($serviceName)->firstOrFail();

        ScrapeDataSourceJob::dispatch($dataSource);
    }
}
