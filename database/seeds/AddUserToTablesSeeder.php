<?php

use Illuminate\Database\Seeder;
use App\Models\{Dinamizador, Infocenter, Gestor, Talento, Idea};
use App\User;

class AddUserToTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            // $ideas = Idea::all();
            $gestores = Gestor::all();
            $talentos = Talento::all();
            $infocenters = Infocenter::all();
            $dinamizadores = Dinamizador::all();
            $ideas = Idea::whereNotNull('correo_contacto')->get();
            foreach ($ideas as $key => $idea) {
                if ($idea->talento_id == null) {
                    $user_id =  User::where('email', $idea->correo_contacto)->first();
                    if ($user_id != null) {
                        $idea->update([
                            'user_id' => $user_id->id
                        ]);
                    }
                }
            }
            foreach ($infocenters as $key => $infocenter) {
                DB::table('user_nodo')->insert(
                    [
                        'user_id' => $infocenter->user_id, 
                        'nodo_id' => $infocenter->nodo_id,
                        'role' => User::IsInfocenter(),
                        'honorarios' => 0,
                        'created_at' => $infocenter->created_at,
                        'updated_at' => $infocenter->updated_at
                    ]
                );
            }

            foreach ($dinamizadores as $key => $dinanizador) {
                DB::table('user_nodo')->insert(
                    [
                        'user_id' => $dinanizador->user_id, 
                        'nodo_id' => $dinanizador->nodo_id,
                        'role' => User::IsDinamizador(),
                        'honorarios' => 0,
                        'created_at' => $dinanizador->created_at,
                        'updated_at' => $dinanizador->updated_at
                    ]
                );
            }

            foreach ($gestores as $key1 => $gestor) {
                DB::table('comite_gestor')
                ->where('gestor_id', $gestor->id)
                ->update(['evaluador_id' => $gestor->user_id]);

                DB::table('gestor_uso')
                ->where('gestor_id', $gestor->user_id)
                ->update(['asesor_id' => $gestor->user_id]);
                
                DB::table('proyectos')
                ->where('asesor_id', $gestor->id)
                ->update(['experto_id' => $gestor->user_id]);
                
                DB::table('ideas')
                ->where('gestor_id', $gestor->id)
                ->update(['asesor_id' => $gestor->user_id]);
                
                DB::table('user_nodo')->insert(
                    [
                        'user_id' => $gestor->user_id, 
                        'nodo_id' => $gestor->nodo_id,
                        'role' => User::IsExperto(),
                        'honorarios' => $gestor->honorarios,
                        'linea_id' => $gestor->lineatecnologica_id,
                        'created_at' => $gestor->created_at,
                        'updated_at' => $gestor->updated_at
                    ]
                );
            }
            foreach ($talentos as $key3 => $talento) {
                DB::table('uso_talentos')
                ->where('talento_id', $talento->id)
                ->update(['user_id' => $talento->user_id]);

                DB::table('proyecto_talento')
                ->where('talento_id', $talento->id)
                ->update(['user_id' => $talento->user_id]);

                DB::table('ideas')
                ->where('talento_id', $talento->id)
                ->update(['user_id' => $talento->user_id]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
