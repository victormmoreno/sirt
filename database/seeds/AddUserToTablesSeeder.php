<?php

use Illuminate\Database\Seeder;
use App\Models\{Dinamizador, Infocenter, Gestor, Talento, Idea, UsoInfraestructura, Ingreso};
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
            $ingresos = DB::table('ingresos')->select('*')->get();
            $gestores = DB::table('gestores')->select('*')->get();
            $talentos = DB::table('talentos')->select('*')->get();
            $infocenters = DB::table('infocenter')->select('*')->get();
            $dinamizadores = DB::table('dinamizador')->select('*')->get();
            $ideas = Idea::whereNotNull('correo_contacto')->get();
            $gestor_uso = DB::table('gestor_uso')->select('*')->get();


            foreach ($gestor_uso as $key => $uso) {
                DB::table('gestor_uso')->where('id', $uso->id)->update(['asesor_id' => $uso->asesorable_id]);
            }
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

            foreach ($ingresos as $key => $ingreso) {
                DB::table('user_nodo')->insert(
                    [
                        'user_id' => $ingreso->user_id,
                        'nodo_id' => $ingreso->nodo_id,
                        'role' => User::IsIngreso(),
                        'honorarios' => 0,
                        'created_at' => $ingreso->created_at,
                        'updated_at' => $ingreso->updated_at
                    ]
                );
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
            // $talents = DB::table('talentos')
            //             ->join('users', 'users.id', '=', 'talentos.user_id')
            //             ->leftJoin('tipo_formacion','tipo_formacion.id', '=', 'talentos.tipo_formacion_id')
            //             ->get();
            // $request = new Illuminate\Http\Request;

            // foreach ($talents as $talents) {
            //     $user = App\User::where('id', $talento->user_id)->first();
            //     $request->merge([
            //         'tipo_talento' => 'funcionario_sena',
            //         'regional' => 1,
            //         'centro_formacion' => 2,
            //         'programa_formacion' => 'Adsi',
            //         'tipo_formacion' => 1
            //     ]);
            //     $user->saveInformationTalent($request);
            // }


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
