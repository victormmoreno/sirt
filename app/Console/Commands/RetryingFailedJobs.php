<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class RetryingFailedJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queuework:retry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para reintentar ejecutar jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('queue:retry all');

        $this->info('crob jobs retried');
    }
}
