<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;

class DisableOfficialsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'officials:disabled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'deactivate officials with expired contracts';

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
        $users = DB::table('users')
        ->join('user_nodo', 'user_nodo.user_id', '=', 'users.id')
        ->join('contratos', 'contratos.user_nodo_id', '=', 'user_nodo.id')
        ->where('contratos.fecha_finalizacion', Carbon::today())
        ->groupBy('users.documento')
        ->update([
            'users.estado' => User::IsInactive(),
            'users.deleted_at' =>  Carbon::today()
        ]);
        $this->info("{$users} offcials disabled");
    }
}
