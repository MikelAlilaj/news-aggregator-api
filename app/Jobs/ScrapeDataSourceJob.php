<?php

namespace App\Jobs;

use App\Models\DataSource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ScrapeDataSourceJob implements ShouldQueue
{
    use Queueable;

    protected $dataSource;

    /**
     * Create a new job instance.
     */
    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $serviceClass = $this->dataSource->getServiceClass();
        $serviceClass->scrape($this->dataSource);
    }
}
