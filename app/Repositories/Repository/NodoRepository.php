<?php

namespace Repositories\Repository;

use App\Models\{LineaTecnologica, Nodo, Entidad, CostoAdministrativo, Centro};
use App\User;
use App\Models\Regional;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NodoRepository
{
    public function getAlltNodo()
    {

        return Nodo::select('entidades.id', DB::raw("CONCAT('Tecnoparque Nodo ',entidades.nombre) as nodos"), "nodos.direccion", DB::raw("CONCAT(centros.codigo_centro,' -  ',ent.nombre) as centro"), DB::raw("CONCAT(ciudades.nombre,' (',departamentos.nombre,') ') as ubicacion"), 'entidades.slug')
            ->join('centros', 'centros.id', '=', 'nodos.centro_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->join('entidades as ent', 'ent.id', '=', 'centros.entidad_id')
            ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
            ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
            ->orderBy('nodos', 'ASC')
            ->get();
    }

    public function findByid($id)
    {
        return Entidad::whereHas('nodo')->findOrFail($id);
    }

    public function getSelectNodo()
    {
        return Nodo::SelectNodo()->get();
    }

    /*=================================================================================
    =            metodo para consultar todos los centros de formacion SENA            =
    =================================================================================*/

    public function getAllCentros()
    {
        return Centro::allCentros()->pluck('nombre', 'id');
    }

    /*=====  End of metodo para consultar todos los centros de formacion SENA  ======*/

    /*================================================================
    =            metaodo para consultar todas las lineas             =
    ================================================================*/

    public function getAllLineas()
    {
        return LineaTecnologica::AllLineas();
    }

    /*=====  End of metaodo para consultar todas las lineas   ======*/

    /*===========================================================================
    =            metodo para consultar todos las regionales del pais            =
    ===========================================================================*/

    public function getAllRegionales()
    {
        return Regional::allRegionales()->pluck('nombre', 'id');
    }

    /*=====  End of metodo para consultar todos las regionales del pais  ======*/

    /*===================================================
    =            metodo para guardar un nodo            =
    ===================================================*/

    public function storeNodo($request)
    {

        DB::beginTransaction();

        try {

            $entidad = Entidad::create([
                'ciudad_id'     => $request->input('txtciudad'),
                'nombre'        => $request->input('txtnombre'),
                'slug'          => str_slug('Tecnoparque nodo ' . $request->input('txtnombre'), '-'),
                'email_entidad' => $request->input('txtemail_entidad'),
            ]);

            $nodo = Nodo::create([
                'entidad_id'  => $entidad->id,
                'centro_id'   => $request->input('txtcentro'),
                'direccion'   => $request->input('txtdireccion'),
                'anho_inicio' => Carbon::now()->format('Y'),
                'telefono'    => $request->input('txttelefono'),
                'extension'    => $request->input('txtextension'),
            ]);

            if ($request->filled('txtlineas')) {
                $syncDataLinea = [];
                foreach ($request->get('txtlineas') as $id => $value) {
                    $syncDataLinea[$id] = [
                        'linea_tecnologica_id' => $value
                    ];
                }

                $nodo->lineas()->sync($syncDataLinea);
            }



            $costo = CostoAdministrativo::all();
            if (!$costo->isEmpty()) {
                $syncData = array();
                foreach ($costo as $id => $value) {
                    $syncData[$id] = array('costo_administrativo_id' => $value->id,  'anho' => Carbon::now()->year, 'valor' => 0);
                }
                $nodo->costoadministrativonodo()->attach($syncData);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /*=====  End of metodo para guardar un nodo  ======*/

    /*======================================================
    =            metodo para actualizar un nodo            =
    ======================================================*/
    public function Update($request, $entidadNodo)
    {

        DB::beginTransaction();

        try {

            $entidadNodo->update([
                'ciudad_id'     => $request->input('txtciudad'),
                'nombre'        => $request->input('txtnombre'),
                'slug'          => str_slug('tecnoparque nodo ' . $request->input('txtnombre'), '-'),
                'email_entidad' => $request->input('txtemail_entidad'),
            ]);

            $entidadNodo->nodo->update([
                'centro_id' => $request->input('txtcentro'),
                'direccion' => $request->input('txtdireccion'),
                'telefono'  => $request->input('txttelefono'),
                'extension'  => $request->input('txtextension'),
            ]);

            if ($request->filled('txtlineas')) {

                $syncDataLinea = [];
                foreach ($request->get('txtlineas') as $id => $value) {

                    $syncDataLinea[$id] = [
                        'linea_tecnologica_id' => $value
                    ];
                }

                $entidadNodo->nodo->lineas()->detach();

                $entidadNodo->nodo->lineas()->attach($syncDataLinea);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /*=====  End of metodo para actualizar un nodo  ======*/

    /**
     * mostar equipo humano de tecnoparque.
     *
     * @return array
     * @author julian londo単o
     */
    public function getTeamTecnoparque()
    {

        return Nodo::teamTecnoparque([
            'entidad',
            'entidad.ciudad',
            'entidad.ciudad.departamento',
            'centro',
            'centro.entidad',
            'centro.entidad.ciudad',
            'centro.entidad.ciudad.departamento',
            'centro.regional',
            'lineas',
            'dinamizador',
            'dinamizador.user',
            'infocenter',
            'infocenter.user',
            'gestores',
            'gestores.user',
            'gestores.lineatecnologica',
            'ingresos',
            'ingresos.user',
        ]);
            
        
        // ->orWhereHas('infocenter.user', function ($query){
        //     $query->where('estado', User::IsActive())
        //             ->where('deleted_at',null);
        // })
        // ->orWhereHas('dinamizador.user', function ($query){
        //     $query->where('estado', User::IsActive())
        //             ->where('deleted_at',null);
        // })
        // ->orWhereHas('ingresos.user', function ($query){
        //     $query->where('estado', User::IsActive())
        //             ->where('deleted_at',null);
        // });
    }

    /**
     * metodo para consular la informacion del nodo por el slug
     * @param string nodo
     * @author julian londo単o
     * @return collection
     */
    public function findNodoForShow(string $nodo)
    {
        return $this->getTeamTecnoparque()->findOrFailNodo($nodo);
    }
}