<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\{Proyecto, Movimiento, Fase, Role};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddDateToProyectosTableSeeder extends Seeder
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
            $proyectos = Proyecto::all();
            // Log::useDailyFiles(storage_path().'/logs/actualizacion_fechas.log');
            Log::channel('seeder')->info('[----------------------------------Actualizando las fechas de fase de cada proyecto----------------------------------]'); 
            // Log::info(['']);
            foreach ($proyectos as $key => $proyecto) {
                Log::channel('seeder')->info('[[---------------Proyecto id: ' . $proyecto->id. ' ---------------]]');
                Log::channel('seeder')->info('Código de proyecto: ' . $proyecto->codigo_proyecto);
                Log::channel('seeder')->info('Nombre de proyecto: ' . $proyecto->nombre);
                $fecha_planeacion = null;
                $fecha_ejecucion = null;
                $fecha_cierre = null;

                $fecha_planeacion = $this->getFechaInicioPlaneacion($proyecto);
                Log::channel('seeder')->info('Fecha de planeación: ' . $fecha_planeacion);
                $fecha_ejecucion = $this->getFechaInicioEjecucion($proyecto);
                Log::channel('seeder')->info('Fecha de ejecución: ' . $fecha_ejecucion);
                $fecha_cierre = $this->getFechaInicioCierre($proyecto);
                Log::channel('seeder')->info('Fecha de cierre: ' . $fecha_cierre);
                
                $proyecto->update([
                    'fecha_inicio_planeacion' => $fecha_planeacion,
                    'fecha_inicio_ejecucion' => $fecha_ejecucion,
                    'fecha_inicio_cierre' => $fecha_cierre
                ]);
            }
            Log::channel('seeder')->info('[----------------------------------Fin de la actualización de las fechas de fase de cada proyecto----------------------------------]'); 
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('seeder')->info('Error: ' . $th->getMessage());
            $this->command->error('Error: ' . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Retorna la fecha de aprobación del dinamizador de la fase de inicio, lo que implica en la fecha de inicio de la fase de planeación
     *
     * @param Proyecto $proyecto
     * @return string
     * @author dum
     **/
    public function getFechaInicioPlaneacion($proyecto)
    {
        $query = $this->getQuery($proyecto)->where('fases.nombre', Proyecto::IsInicio())->get();

        if ($query->count() == 0) {
            return null;
        } else {
            return $query->last()->created_at;
        }
    }

    /**
     * Retorna la fecha de aprobación del dinamizador de la fase de planeación, lo que implica en la fecha de inicio de la fase de ejecucion
     *
     * @param Proyecto $proyecto
     * @return string
     * @author dum
     **/
    public function getFechaInicioEjecucion($proyecto)
    {
        $query = $this->getQuery($proyecto)->where('fases.nombre', Proyecto::IsPlaneacion())->get();

        if ($query->count() == 0) {
            return null;
        } else {
            return $query->last()->created_at;
        }
    }

    /**
     * Retorna la fecha de aprobación del dinamizador de la fase de ejecución, lo que implica en la fecha de inicio de la fase de cierre
     *
     * @param Proyecto $proyecto
     * @return string
     * @author dum
     **/
    public function getFechaInicioCierre($proyecto)
    {
        $query = $this->getQuery($proyecto)->where('fases.nombre', Proyecto::IsEjecucion())->get();

        if ($query->count() == 0) {
            return null;
        } else {
            return $query->last()->created_at;
        }
    }

    /**
     * Obtiene el query
     */
    public function getQuery($proyecto) {
        return DB::table('movimientos_actividades_users_roles')->select('proyecto_id', 'fases.nombre', 'movimientos.movimiento', 'movimientos_actividades_users_roles.created_at')
        ->where('proyecto_id', $proyecto->id)
        ->where('movimientos.movimiento', Movimiento::IsAprobar())
        ->where('roles.name', User::IsDinamizador())
        ->join('movimientos', 'movimientos.id', 'movimientos_actividades_users_roles.movimiento_id')
        ->join('fases', 'fases.id', '=', 'movimientos_actividades_users_roles.fase_id')
        ->join('users', 'users.id', '=', 'movimientos_actividades_users_roles.user_id')
        ->join('roles', 'roles.id', '=', 'movimientos_actividades_users_roles.role_id')
        ->orderBy('movimientos_actividades_users_roles.created_at');
    }
}
