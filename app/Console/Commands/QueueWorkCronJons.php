<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class QueueWorkCronJons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queuework:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta comando php artisan queue work con tareas programadas';

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
        Artisan::call('queue:work --stop-when-empty');

        $this->info('crob jobs executed');
    }
}
