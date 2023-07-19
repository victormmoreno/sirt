<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class MarkInformationTalentIncompleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:mark-information-talent-incomplete {--document=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'mark information as incomplete every few days';

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
        $dateCurrent = \Carbon\Carbon::now()->format('Y-m-d');
        $userOption = $this->option('document');
        if(isset($userOption) && $userOption == 'default'){
            $users = User::query()
                    ->select('users.id', 'users.documento', 'users.nombres', 'users.apellidos', 'users.email', 'informacion_user_completed_at')
                    ->withTrashed()
                    ->join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                            ->where('model_has_roles.model_type', User::class);
                    })
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->where('roles.name', User::IsTalento())
                    ->get();
            if(isset($users) && $users->count() > 0)
            {
                $users->map(function($user) use($dateCurrent){
                    if(!is_null($user->informacion_user_completed_at) && $user->informacion_user_completed_at->diffInMonths($user->informacion_user_completed_at->copy()->addMonths(3)) == 3 && $user->informacion_user_completed_at->copy()->addMonths(3)->format('Y-m-d') == $dateCurrent){
                        $user->markInformationTalentAsIncompleted();
                    }
                });
                return  $this->info("Información marcada como incompleta");
            }
        }
        else if(isset($userOption)){
            $users = User::query()
                    ->select('users.id', 'users.documento', 'users.nombres', 'users.apellidos', 'users.email', 'informacion_user_completed_at')
                    ->withTrashed()
                    ->join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                            ->where('model_has_roles.model_type', User::class);
                    })
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->where('documento', $userOption)
                    ->where('roles.name', User::IsTalento())
                    ->first();
            if(isset($users)){
                if(!is_null($users->informacion_user_completed_at) && $users->informacion_user_completed_at->diffInMonths($users->informacion_user_completed_at->copy()->addMonths(3)) == 3 && $users->informacion_user_completed_at->copy()->addMonths(3)->format('Y-m-d') == $dateCurrent ){
                    $users->markInformationTalentAsIncompleted();
                    //$this->info("{$users->informacion_user_completed_at->diffInMonths($users->informacion_user_completed_at->copy()->addMonths(3))}");
                    return $this->info("Información marcada como incompleta | {$users->documento} - {$users->nombres} {$users->apellidos} {$users->informacion_user_completed_at->copy()->addMonths(3)->format('Y-m-d')}");
                }
                return $this->info("Información no marcada como incompleta | {$users->documento} - {$users->nombres} {$users->apellidos}");
            }

        }else{
            return $this->error("Error!.");
        }


    }
}
