<?php

namespace App\Repositories\Repository;

use App\Models\Equipo;
use App\User;
use Illuminate\Support\Facades\DB;

class EquipoRepository
{
    public function getInfoDataEquipos()
    {
        return Equipo::with([
            'nodo' => function($query){
                $query->select('id', 'centro_id', 'entidad_id', 'direccion', 'telefono', 'anho_inicio');
            },
            'nodo.entidad' => function($query){
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
                'nodo_id' =>  session()->get('login_role') == User::IsDinamizador() ? auth()->user()->dinamizador->nodo->id : session()->get('login_role') == User::IsGestor() ? auth()->user()->gestor->nodo->id : auth()->user()->dinamizador->nodo->id,
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
                'nodo_id' =>  session()->get('login_role') == User::IsDinamizador() ? auth()->user()->dinamizador->nodo->id : session()->get('login_role') == User::IsGestor() ? auth()->user()->gestor->nodo->id : auth()->user()->dinamizador->nodo->id,
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
