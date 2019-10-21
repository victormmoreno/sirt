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

        Material::create([
            'nodo_id'               => $this->findNodoBySession($request),
            'lineatecnologica_id'   => $this->findLineaBySession($request),
            'tipomaterial_id'       => $request->input('txttipomaterial'),
            'categoria_material_id' => $request->input('txtcategoria'),
            'presentacion_id'       => $request->input('txtpresentacion'),
            'medida_id'             => $request->input('txtmedida'),
            'fecha'                 => $request->input('txtfecha'),
            'codigo_material'       => $this->generateCodigoMaterial($request),
            'nombre'                => $request->input('txtnombre'),
            'cantidad'              => $request->input('txtcantidad'),
            'valor_compra'          => $request->input('txtvalorcompra'),
            'horas_uso_anio'        => $request->input('txthorasuso'),
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
                'nodo_id'               => $this->findNodoBySession($request),
                'lineatecnologica_id'   => $this->findLineaBySession($request),
                'tipomaterial_id'       => $request->input('txttipomaterial'),
                'categoria_material_id' => $request->input('txtcategoria'),
                'presentacion_id'       => $request->input('txtpresentacion'),
                'medida_id'             => $request->input('txtmedida'),
                'fecha'                 => $request->input('txtfecha'),
                'nombre'                => $request->input('txtnombre'),
                'cantidad'              => $request->input('txtcantidad'),
                'valor_compra'          => $request->input('txtvalorcompra'),
                'horas_uso_anio'        => $request->input('txthorasuso'),
                'proveedor'             => $request->input('txtproveedor'),
                'marca'                 => $request->input('txtmarca'),
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    private function generateCodigoMaterial($request)
    {
        $anho = Carbon::now()->isoFormat('YYYY');

        $nodoAuth = session()->has('login_role') && session()->get('login_role') == User::Isgestor() ? auth()->user()->gestor->nodo->id : auth()->user()->dinamizador->nodo->id;

        $nodo = Nodo::find($nodoAuth);

        $lineaAuth = session()->has('login_role') && session()->get('login_role') == User::Isgestor() ? auth()->user()->gestor->lineatecnologica_id : $request->input('txtlineatecnologica');

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
        return session()->get('login_role') == User::IsDinamizador() ? auth()->user()->dinamizador->nodo->id : session()->get('login_role') == User::IsGestor() ? auth()->user()->gestor->nodo->id : auth()->user()->dinamizador->nodo->id;

    }

    /**
     * devolve consulta de la tabla linea.
     *
     * @return array
     * @author devjul
     */
    private function findLineaBySession($request)
    {

        $nodoAuth = session()->has('login_role') && session()->get('login_role') == User::Isgestor() ? auth()->user()->gestor->nodo->id : auth()->user()->dinamizador->nodo->id;

        $nodo = Nodo::find($nodoAuth);

        $lineaAuth = session()->has('login_role') && session()->get('login_role') == User::Isgestor() ? auth()->user()->gestor->lineatecnologica_id : $request->input('txtlineatecnologica');

        return $nodo->lineas->find($lineaAuth)->id;

    }


}
