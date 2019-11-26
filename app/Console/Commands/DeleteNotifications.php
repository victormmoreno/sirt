<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:deletenotifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina las notificaciones que tienen al menos un mes de haberse creado';

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
        DB::table('notifications')->whereRaw('DATEDIFF(DATE_FORMAT(created_at, "%Y-%m-%d"), NOW()) <= -31')->delete();
        $this->info('Registros eliminados.');
    }
}
