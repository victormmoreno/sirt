<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class AddInfoTalentsToUsersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        $this->command->info('Cambiando informacion de talentos...');
        try {
            $talents = DB::table('talentos')
                        ->select(
                            'users.id as user_id', 'users.documento','users.nombres','users.apellidos', 'users.email',
                            'tipo_talentos.nombre as tipo_talento', 'entidades.nombre as entidad',
                            'centros.id as centro_id',
                            'regionales.nombre as regional', 'regionales.id as regional_id',
                            'tipo_formacion.nombre as tipo_formacion', 'tipo_formacion.id as tipo_formacion_id',
                            'tipo_estudio.nombre as tipo_estudio','tipo_estudio.id as tipo_estudio_id',
                            'talentos.universidad', 'talentos.programa_formacion', 'talentos.carrera_universitaria',
                            'talentos.empresa', 'talentos.dependencia'
                            )
                        ->join('users', 'users.id', '=', 'talentos.user_id')
                        ->leftJoin('tipo_formacion','tipo_formacion.id', '=', 'talentos.tipo_formacion_id')
                        ->join('tipo_talentos','tipo_talentos.id', '=', 'talentos.tipo_talento_id')
                        ->leftJoin('entidades','entidades.id', '=', 'talentos.entidad_id')

                        ->leftJoin('centros','centros.entidad_id', '=', 'entidades.id')
                        ->leftJoin('regionales','regionales.id', '=', 'centros.regional_id')
                        ->leftJoin('tipo_estudio','tipo_estudio.id', '=', 'talentos.tipo_estudio_id')
                        ->orderBy('users.documento')
                        ->get();
                        $request = new Request;
                        foreach ($talents as $key => $talent) {
                            $user = App\User::where('documento', $talent->documento)->first();
                            if(isset($user ) && isset($talent->tipo_talento)){
                                if($talent->tipo_talento == \App\Models\TipoTalento::IS_APRENDIZ_SENA_CON_APOYO){
                                    $request->merge([
                                        'tipo_talento' => 'aprendiz_sena_con_apoyo_de_sostenimiento',
                                        'regional' => $talent->regional_id,
                                        'centro_formacion' => $talent->centro_id,
                                        'programa_formacion' => $talent->programa_formacion,
                                    ]);
                                }
                                else if($talent->tipo_talento == \App\Models\TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO){
                                    $request->merge([
                                        'tipo_talento' => 'aprendiz_sena_sin_apoyo_de_sostenimiento',
                                        'regional' => $talent->regional_id,
                                        'centro_formacion' => $talent->centro_id,
                                        'programa_formacion' => $talent->programa_formacion
                                    ]);
                                }
                                else if($talent->tipo_talento == \App\Models\TipoTalento::IS_EGRESADO_SENA){
                                    $request->merge([
                                        'tipo_talento' => 'egresado_sena',
                                        'regional' => $talent->regional_id,
                                        'centro_formacion' => $talent->centro_id,
                                        'programa_formacion' => $talent->programa_formacion,
                                        'tipo_formacion' => $talent->tipo_formacion_id,
                                    ]);
                                }
                                else if($talent->tipo_talento == \App\Models\TipoTalento::IS_EMPRENDEDOR)
                                {
                                    $request->merge([
                                        'tipo_talento' => 'emprendedor'
                                    ]);
                                }
                                else if($talent->tipo_talento == \App\Models\TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO){
                                    $request->merge([
                                        'tipo_talento' => 'estudiante_universitario',
                                        'tipo_estudio' => $talent->tipo_estudio_id,
                                        'universidad' => $talent->universidad,
                                        'carrera' => $talent->carrera_universitaria,
                                    ]);
                                }
                                else if($talent->tipo_talento == \App\Models\TipoTalento::IS_FUNCIONARIO_EMPRESA){
                                    $request->merge([
                                        'tipo_talento' => 'funcionario_de_empresa',
                                        'empresa' => $talent->empresa
                                    ]);
                                }
                                else if($talent->tipo_talento == \App\Models\TipoTalento::IS_FUNCIONARIO_SENA){
                                    $request->merge([
                                        'tipo_talento' => 'funcionario_sena',
                                        'regional' => $talent->regional_id,
                                        'centro_formacion' => $talent->centro_id,
                                        'dependencia' => $talent->dependencia
                                    ]);
                                }
                                else if($talent->tipo_talento == \App\Models\TipoTalento::IS_INSTRUCTOR_SENA){
                                    $request->merge([
                                        'tipo_talento' => 'instructor_sena',
                                        'regional' => $talent->regional_id,
                                        'centro_formacion' => $talent->centro_id
                                    ]);
                                }
                                else if($talent->tipo_talento == \App\Models\TipoTalento::IS_PROPIETARIO_EMPRESA){
                                    $request->merge([
                                        'tipo_talento' => 'propietario_empresa',
                                        'empresa' => $talent->empresa
                                    ]);
                                }
                                $user->saveInformationTalent($request);
                                // echo "{$key}: usuario {$talent->documento} {$talent->nombres} {$talent->apellidos} actualizado \n";
                            }

                        }
                        $this->command->info('Informacion talento cambiada con éxito');
            DB::commit();
        }catch (\Throwable $th) {
            DB::rollBack();
            $this->command->error('Error: '. $th->getMessage());
            throw $th;
        }
    }
}
