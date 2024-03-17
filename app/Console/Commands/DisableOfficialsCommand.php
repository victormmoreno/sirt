<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Collection;

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
        $users = User::query()
        ->join('user_nodo', 'user_nodo.user_id', '=', 'users.id')
        ->join('contratos', 'contratos.user_nodo_id', '=', 'user_nodo.id')
        // ->where('users.documento', '1042348706')
        ->where('contratos.fecha_finalizacion', Carbon::today())
        ->groupBy('users.documento')
        ->get();

        $users->map(function($user){
            // $user->roles()->detach();
            $user->syncRoles(User::IsUsuario());
            $user->update([
                'users.estado' => User::IsInactive(),
                'users.deleted_at' =>  Carbon::today()
            ]);
            $user->refresh();
        });

        $this->info("{$users->count()} offcials disabled");
    }
}
