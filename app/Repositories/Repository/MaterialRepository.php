<?php

namespace App\Repositories\Repository;

use Carbon\Carbon;
use App\Models\Nodo;
use App\Models\Material;
use App\Models\Medida;
use App\User;
use Illuminate\Support\Facades\DB;

class MaterialRepository
{

	public function store($request)
	{
		// return $this->findLineaBySession($request);

		DB::beginTransaction();

			Material::create([
                'nodo_id' => $this->findNodoBySession($request),
                'lineatecnologica_id' =>  $this->findLineaBySession($request),
                'tipomaterial_id'               => $request->input('txttipomaterial'),
                'categoria_material_id'           => $request->input('txtcategoria'),
                'presentacion_id'                => $request->input('txtpresentacion'),
                'medida_id'    => $request->input('txtmedida'),
                'codigo_material'            => $this->generateCodigoMaterial($request),
                'nombre'          => $request->input('txtnombre'),
                'cantidad'       => $request->input('txtcantidad'),
                'valor_compra'       => $request->input('txtvalorcompra'),
                'proveedor'       => $request->input('txtproveedor'),
                'marca'       => $request->input('txtmarca'),
            ]);

        try {
			
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

        $nodoAuth =  session()->has('login_role') && session()->get('login_role') == User::Isgestor() ? auth()->user()->gestor->nodo->id : auth()->user()->dinamizador->nodo->id;

        $nodo = Nodo::find($nodoAuth);
       
        $lineaAuth = session()->has('login_role') && session()->get('login_role') == User::Isgestor() ? auth()->user()->gestor->lineatecnologica_id : $request->input('txtlineatecnologica');

        $tecnoparque = sprintf("%02d", $nodo->id);
        
        $idMaterial = Material::selectRaw('MAX(id+1) AS max')->get()->last();
        $idMaterial->max == null ? $idMaterial->max = 1 : $idMaterial->max = $idMaterial->max;
        $idMaterial->max = sprintf("%05d", $idMaterial->max);
        $codigo = 'MAT'. $anho  . $tecnoparque . sprintf("%02d",$nodo->lineas->find($lineaAuth)->id) .  $idMaterial->max;

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

    	$nodoAuth =  session()->has('login_role') && session()->get('login_role') == User::Isgestor() ? auth()->user()->gestor->nodo->id : auth()->user()->dinamizador->nodo->id;

        $nodo = Nodo::find($nodoAuth);

        $lineaAuth = session()->has('login_role') && session()->get('login_role') == User::Isgestor() ? auth()->user()->gestor->lineatecnologica_id : $request->input('txtlineatecnologica');

        return $nodo->lineas->find($lineaAuth)->id;
      
        
    }



}