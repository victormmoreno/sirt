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
        } catch (\Exception $e) {
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
                'nodo_id' => $this->findLineaTecnologicaNodoByRequest(),
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
        } catch (\Exception $e) {
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
    private function findLineaTecnologicaNodoByRequest()
    {
        if (session()->get('login_role') == User::IsDinamizador()) {
            return auth()->user()->dinamizador->nodo_id;
        }

    }
}
