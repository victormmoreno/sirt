<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Models\UserNodo;

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
                    UserNodo::create([
                        'user_id' => $user->id,
                        'nodo_id' => $user->gestor->nodo_id,
                        'role' => User::IsArticulador(),
                        'honorarios' => $user->gestor->honorarios,
                    ]);
                    // Gestor::find($user->gestor->id)->delete();
                }
            }
        }
    }
}
