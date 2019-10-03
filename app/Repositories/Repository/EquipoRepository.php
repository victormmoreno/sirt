<?php

namespace App\Repositories\Repository;

use App\Models\Equipo;
use Illuminate\Support\Facades\DB;

class EquipoRepository
{
    public function getInfoDataEquipos()
    {
        return Equipo::select('equipos.id', 'equipos.referencia', 'equipos.nombre as nombreequipo', 'equipos.marca', 'equipos.vida_util','equipos.costo_adquisicion', 'equipos.anio_compra', 'equipos.created_at', 'lineastecnologicas.nombre as nombrelinea', 'lineastecnologicas.abreviatura','lineastecnologicas.id as lineatecnologica_id', 'nodos.id as nodoid')
        ->join('lineastecnologicas','lineastecnologicas.id','=', 'equipos.lineatecnologica_id')
        ->join('lineastecnologicas_nodos','lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
        ->join('nodos', 'nodos.id', '=', 'lineastecnologicas_nodos.nodo_id');
    }



    public function storeEquipo($request)
    {
        DB::beginTransaction();

        try {

            Equipo::create([
                'lineatecnologica_id' => $request->input('txtlineatecnologica'),
                'nombre'              => $request->input('txtnombre'),
                'referencia'          => $request->input('txtreferencia'),
                'marca'               => $request->input('txtmarca'),
                'costo_adquisicion'   => $request->input('txtcostoadquisicion'),
                'vida_util'           => $request->input('txtvida_util'),
                'anio_compra'         => $request->input('txtaniocompra'),
            ]);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }


    /**
     * devolve actualizacion de equipos .
     *
     * @return boolean
     * @author devjul
     */
    public function updateEquipo($request, $equipo)
    {
        // 
        DB::beginTransaction();

        try {

            $equipo->update([
                'lineatecnologica_id' => $request->input('txtlineatecnologica'),
                'nombre'              => $request->input('txtnombre'),
                'referencia'          => $request->input('txtreferencia'),
                'marca'               => $request->input('txtmarca'),
                'costo_adquisicion'   => $request->input('txtcostoadquisicion'),
                'vida_util'           => $request->input('txtvida_util'),
                'anio_compra'         => $request->input('txtaniocompra'),
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
