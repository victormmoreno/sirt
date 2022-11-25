<?php

namespace App\Repositories\Repository;

use App\Models\Material;
use App\Models\Nodo;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MaterialRepository
{
    public function getInfoDataMateriales()
    {
        return Material::with([
            'nodo'              => function ($query) {
                $query->select('id', 'centro_id', 'entidad_id', 'direccion', 'telefono', 'anho_inicio');
            },
            'nodo.entidad'      => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'slug', 'email_entidad');
            },
            'lineatecnologica',
            'presentacion'      => function ($query) {
                $query->select('id', 'nombre');
            },
            'medida'            => function ($query) {
                $query->select('id', 'nombre');
            },
            'tipomaterial'      => function ($query) {
                $query->select('id', 'nombre');
            },
            'categoriamaterial' => function ($query) {
                $query->select('id', 'nombre');
            },

        ]);
    }

    public function store($request)
    {

        DB::beginTransaction();

        // dd($this->findLineaBySession($request));
        Material::create([
            'nodo_id'               => $this->findNodoBySession(),
            'lineatecnologica_id'   => $this->findLineaBySession($request),
            'tipomaterial_id'       => 1,
            'categoria_material_id' => $request->input('txtcategoria'),
            'presentacion_id'       => $request->input('txtpresentacion'),
            'medida_id'             => $request->input('txtmedida'),
            'fecha'                 => $request->input('txtfecha'),
            'codigo_material'       => $this->generateCodigoMaterial($request),
            'nombre'                => $request->input('txtnombre'),
            'cantidad'              => $request->input('txtcantidad'),
            'valor_compra'          => $request->input('txtvalorcompra'),
            'proveedor'             => $request->input('txtproveedor'),
            'marca'                 => $request->input('txtmarca'),
        ]);

        try {

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }


    /**
     * devolve actualizacion de un material .
     *
     * @return boolean
     * @author devjul
     */
    public function updateMaterial($request, $material)
    {
       
        DB::beginTransaction();

        try {

            $material->update([
                'nodo_id'               => $this->findNodoBySession(),
                'lineatecnologica_id'   => $this->findLineaBySession($request),
                'tipomaterial_id'       => 1,
                'categoria_material_id' => $request->input('txtcategoria'),
                'presentacion_id'       => $request->input('txtpresentacion'),
                'medida_id'             => $request->input('txtmedida'),
                'fecha'                 => $request->input('txtfecha'),
                'nombre'                => $request->input('txtnombre'),
                'cantidad'              => $request->input('txtcantidad'),
                'valor_compra'          => $request->input('txtvalorcompra'),
                'proveedor'             => $request->input('txtproveedor'),
                'marca'                 => $request->input('txtmarca'),
            ]);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollback();
            throw $ex;
            return false;
        }
    }

    private function generateCodigoMaterial($request)
    {
        $anho = Carbon::now()->isoFormat('YYYY');

        $nodo = Nodo::find($this->findNodoBySession());

        $lineaAuth = session()->has('login_role') && session()->get('login_role') == User::IsExperto() ? auth()->user()->gestor->lineatecnologica_id : $request->input('txtlineatecnologica');

        $tecnoparque = sprintf("%02d", $nodo->id);

        $idMaterial                                 = Material::selectRaw('MAX(id+1) AS max')->get()->last();
        $idMaterial->max == null ? $idMaterial->max = 1 : $idMaterial->max = $idMaterial->max;
        $idMaterial->max                            = sprintf("%05d", $idMaterial->max);
        $codigo                                     = 'MAT' . $anho .'-'. $tecnoparque . sprintf("%02d", $nodo->lineas->find($lineaAuth)->id) .'-'. $idMaterial->max;

        return $codigo;
    }

    /**
     * devolve consulta de la tabla nodo.
     *
     * @return array
     * @author devjul
     */
    private function findNodoBySession()
    {
        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            return auth()->user()->dinamizador->nodo_id;
        }elseif(session()->has('login_role') && session()->get('login_role') == User::IsExperto()){
            return auth()->user()->gestor->nodo_id;
        } else {
            return request()->txtnodo_id;
        }
        

    }

    /**
     * devolve consulta de la tabla linea.
     *
     * @return array
     * @author devjul
     */
    private function findLineaBySession($request)
    {

        $nodo = Nodo::find($this->findNodoBySession());
        $lineaAuth = session()->has('login_role') && session()->get('login_role') == User::IsExperto() ? auth()->user()->gestor->lineatecnologica_id : $request->input('txtlineatecnologica');
        // dd($nodo->lineas);

        return $nodo->lineas->find($lineaAuth)->id;

    }


}
