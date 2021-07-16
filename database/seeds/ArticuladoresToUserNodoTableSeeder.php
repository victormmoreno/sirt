<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Models\UserNodo;
use App\Models\Gestor;
use App\Models\Actividad;

class ArticuladoresToUserNodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::with(['gestor'])->whereHas('gestor')->role(App\User::IsArticulador())->get();
        foreach ($users as $key => $user) {
            if ($user->gestor != null) {

                $userNodo = UserNodo::find($user->gestor->id);
                if($userNodo == null)
                {
                    $usernodo = UserNodo::create([
                        'user_id' => $user->id,
                        'nodo_id' => $user->gestor->nodo_id,
                        'role' => User::IsArticulador(),
                        'honorarios' => $user->gestor->honorarios,
                    ]);
                    // $actividad = Actividad::find($user->gestor->id);
                    // $actividad->update([
                    //     'gestor_id' => $usernodo->id
                    // ]);
                    // Gestor::find($user->gestor->id)->delete();

                }
            }
        }
    }
}
