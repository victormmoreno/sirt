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
            'nodo'         => function ($query) {
                $query->select('id', 'centro_id', 'entidad_id', 'direccion', 'telefono', 'anho_inicio');
            },
            'nodo.entidad' => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'slug', 'email_entidad');
            },
            'lineatecnologica'
        ]);
    }

    public function storeEquipo($request)
    {

        DB::beginTransaction();

        try {

            Equipo::create([
                'nodo_id' => $this->findLineaTecnologicaNodoByRequest($request),
                'lineatecnologica_id' => $request->input('txtlineatecnologica'),
                'nombre'               => $request->input('txtnombre'),
                'referencia'           => $request->input('txtreferencia'),
                'marca'                => $request->input('txtmarca'),
                'costo_adquisicion'    => $request->input('txtcostoadquisicion'),
                'vida_util'            => $request->input('txtvida_util'),
                'anio_compra'          => $request->input('txtaniocompra'),
                'horas_uso_anio'       => $request->input('txthorasuso'),
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

        DB::beginTransaction();

        try {

            $equipo->update([
                'nodo_id' => $this->findLineaTecnologicaNodoByRequest($request),
                'lineatecnologica_id' => $request->input('txtlineatecnologica'),
                'nombre'               => $request->input('txtnombre'),
                'referencia'           => $request->input('txtreferencia'),
                'marca'                => $request->input('txtmarca'),
                'costo_adquisicion'    => $request->input('txtcostoadquisicion'),
                'vida_util'            => $request->input('txtvida_util'),
                'anio_compra'          => $request->input('txtaniocompra'),
                'horas_uso_anio'       => $request->input('txthorasuso'),
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
        if (session()->get('login_role') == User::IsDinamizador()) {
            return auth()->user()->dinamizador->nodo_id;
        } else {
            return $request->txtnodo_id;
        }

    }

    /**
     * Retorna el id del nodo
     * 
     * @param Request $request
     * @author dum
     */
    public function getNodoRole($request)
    {
        $nodo = null;
        if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {
            $nodo = $request->filter_nodo;
        }
        if (session()->get('login_role') == User::IsDinamizador()) {
            $nodo = auth()->user()->dinamizador->nodo_id;
        }
        if (session()->get('login_role') == User::IsGestor()) {
            $nodo = auth()->user()->gestor->nodo_id;
        }

        return $nodo;
    }

    /**
     * Retorna el id de la linea tecnológica
     * 
     * @author dum
     */
    public function getLineaRole()
    {
        $linea = null;
        if (session()->get('login_role') == User::IsGestor()) {
            $linea = auth()->user()->gestor->lineatecnologica_id;
        }
        return $linea;
    }
}
