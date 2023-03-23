<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Equipo;

class EquiposCodigoTableSeeder extends Seeder
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
            $equipos = $this->getQuery()->get();
            foreach ($equipos as $key => $equipo) {
                $codigo = $this->generarCodigo($equipo);
                $equipo->update(['codigo' => $codigo]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function getQuery()
    {
        return Equipo::select(
            'nodo_id',
            'lineatecnologica_id',
            'codigo',
            'id',
            'nombre',
            'marca',
            'costo_adquisicion',
            'vida_util',
            'anio_compra',
            'horas_uso_anio',
            'created_at'
        )->withTrashed();
    }

    /**
     * Genera el código para el equipo existente
     *
     * @param Equipo $equipo
     * @return string
     * @author dum
     **/
    private function generarCodigo(Equipo $equipo)
    {
        $codigo = null;
        $prefix = 'EQ';
        $anho = $equipo->anio_compra;
        $nodo = sprintf("%02d", $equipo->nodo_id);
        $linea = sprintf("%02d", $equipo->lineatecnologica_id);
        $id = sprintf("%06d", $equipo->id);
        $codigo = $prefix . $anho . '-' . $nodo . $linea . '-' . $id; 
        return $codigo;
    }

}
