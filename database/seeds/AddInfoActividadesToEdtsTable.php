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
            $edts = Edt::all();
            foreach ($edts as $key => $edt) {
                $codigo_edt = $edt->actividad->codigo_actividad;
                $nombre = $edt->actividad->nombre;
                $fecha_inicio = $edt->actividad->fecha_inicio;
                $fecha_cierre = $edt->actividad->fecha_cierre;
                $objetivo_general = $edt->actividad->objetivo_general;
                $conclusiones = $edt->actividad->conclusiones;
                $formulario_inicio = $edt->actividad->formulario_inicio;
                $cronograma = $edt->actividad->cronograma;
                $seguimiento = $edt->actividad->seguimiento;
                $formulario_final = $edt->actividad->formulario_final;
                $edt->update([
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
