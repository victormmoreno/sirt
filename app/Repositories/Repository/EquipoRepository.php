<?php

namespace App\Repositories\Repository;

use App\Models\Equipo;
use App\Models\LineaTecnologicaNodo;
use App\User;
use Illuminate\Support\Facades\DB;

class EquipoRepository
{
    public function getInfoDataEquipos()
    {
        return Equipo::with([
            'lineatecnologicanodo',
            'lineatecnologicanodo.nodo'         => function ($query) {
                $query->select('id', 'centro_id', 'entidad_id', 'direccion', 'telefono', 'anho_inicio');
            },
            'lineatecnologicanodo.nodo.entidad' => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'slug', 'email_entidad');
            },
            'lineatecnologicanodo.lineatecnologica',
        ]);
    }

    public function storeEquipo($request)
    {
        $lineatecnologica_nodo = $this->findLineaTecnologicaNodoByRequest($request);
        DB::beginTransaction();

        try {

            Equipo::create([
                'lineatecnologica_nodo_id' => $lineatecnologica_nodo->id,
                'nombre'               => $request->input('txtnombre'),
                'referencia'           => $request->input('txtreferencia'),
                'marca'                => $request->input('txtmarca'),
                'costo_adquisicion'    => $request->input('txtcostoadquisicion'),
                'vida_util'            => $request->input('txtvida_util'),
                'anio_compra'          => $request->input('txtaniocompra'),
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
        $lineatecnologica_nodo = $this->findLineaTecnologicaNodoByRequest($request);
        DB::beginTransaction();

        try {

            $equipo->update([
                'linea_tecnologica_id' => $lineatecnologica_nodo->id,
                'nombre'            => $request->input('txtnombre'),
                'referencia'        => $request->input('txtreferencia'),
                'marca'             => $request->input('txtmarca'),
                'costo_adquisicion' => $request->input('txtcostoadquisicion'),
                'vida_util'         => $request->input('txtvida_util'),
                'anio_compra'       => $request->input('txtaniocompra'),
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * devolve consulta de la tabla LineaTecnologicaNodo.
     *
     * @return array
     * @author devjul
     */
    private function findLineaTecnologicaNodoByRequest($request)
    {
        $nodo = session()->get('login_role') == User::IsDinamizador() ? auth()->user()->dinamizador->nodo->id : session()->get('login_role') == User::IsGestor() ? auth()->user()->gestor->nodo->id : auth()->user()->dinamizador->nodo->id;

        $lineatecnologica = LineaTecnologicaNodo::
            where('linea_tecnologica_id', $request->input('txtlineatecnologica'))
            ->where('nodo_id', $nodo)
            ->first();

        return $lineatecnologica;
    }
}
