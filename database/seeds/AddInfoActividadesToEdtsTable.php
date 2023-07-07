<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Edt;

class AddInfoActividadesToEdtsTable extends Seeder
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
            $edts = Edt::select(
                'edts.id', 'actividades.codigo_actividad', 'actividades.nombre', 'actividades.fecha_inicio', 'actividades.fecha_cierre',
                'actividades.objetivo_general', 'actividades.conclusiones', 'actividades.formulario_inicio', 'actividades.cronograma', 
                'actividades.seguimiento', 'actividades.formulario_final'
            )
            ->join('actividades', 'actividades.id', '=', 'edts.actividad_id')
            ->get();
            foreach ($edts as $key => $edt) {
                $codigo_edt = $edt->codigo_actividad;
                $nombre = $edt->nombre;
                $fecha_inicio = $edt->fecha_inicio;
                $fecha_cierre = $edt->fecha_cierre;
                $objetivo_general = $edt->objetivo_general;
                $conclusiones = $edt->conclusiones;
                $formulario_inicio = $edt->formulario_inicio;
                $cronograma = $edt->cronograma;
                $seguimiento = $edt->seguimiento;
                $formulario_final = $edt->formulario_final;
                DB::table('edts')
                ->where('id', $edt->id)->update([
                    'codigo_edt' => $codigo_edt,
                    'nombre' => $nombre,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_cierre' => $fecha_cierre,
                    'objetivo_general' => $objetivo_general,
                    'conclusiones' => $conclusiones,
                    'formulario_inicio' => $formulario_inicio,
                    'cronograma' => $cronograma,
                    'seguimiento' => $seguimiento,
                    'formulario_final' => $formulario_final
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
