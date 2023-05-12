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

    public function generarCodigoEquipo($request)
    {
        $codigo = null;
        $prefix = 'EQ';
        $anho = $request->txtaniocompra;
        $nodo = sprintf("%02d", $request->user()->getNodoUser() == null ? $request->txtnodo_id : $request->user()->getNodoUser());
        $linea = sprintf("%02d", $request->user()->getLineaUser() == null ? $request->txtlineatecnologica : $request->user()->getLineaUser());
        $id = sprintf("%06d", Equipo::selectRaw('MAX(id+1) AS max')->get()->last()->max);
        $codigo = $prefix . $anho . '-' . $nodo . $linea . '-' . $id; 
        return $codigo;
    }

    public function storeEquipo($request)
    {

        DB::beginTransaction();
        try {
            Equipo::create([
                'nodo_id' => $this->findLineaTecnologicaNodoByRequest($request),
                'lineatecnologica_id' => $request->input('txtlineatecnologica'),
                'codigo' => $this->generarCodigoEquipo($request),
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
     * Consulta la información de los materiales
     *
     * @return Builder
     * @author dum
     **/
    public function consultar()
    {
        return Equipo::select(
            'e.nombre as nodo',
            'lt.nombre as linea',
            'codigo',
            'destacado',
            'referencia',
            'equipos.nombre',
            'marca',
            'costo_adquisicion',
            'vida_util',
            'anio_compra',
            'horas_uso_anio',
            'deleted_at'
        )
        ->join('nodos as n', 'n.id', '=', 'equipos.nodo_id')
        ->join('entidades as e', 'e.id', '=', 'n.entidad_id')
        ->join('lineastecnologicas as lt', 'lt.id', '=', 'equipos.lineatecnologica_id')
        ->orderBy('nodo')
        ->orderBy('equipos.nombre');
    }

    /**
     * devolve consulta de la tabla LineaTecnologicaNodo.
     *
     * @return array
     * @author devjul
     */
    private function findLineaTecnologicaNodoByRequest($request)
    {
        if (!isset($request->txtnodo_id)) {
            return request()->user()->getNodoUser();
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
        if (session()->get('login_role') == User::IsExperto()) {
            $nodo = auth()->user()->experto->nodo_id;
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
        if (session()->get('login_role') == User::IsExperto()) {
            $linea = auth()->user()->experto->linea_id;
        }
        return $linea;
    }

    /**
     * Destaca o deja de destacar un equipo
     *
     * @param Equipo $equipo
     * @return bool
     * @author dum
     **/
    public function destacar(Equipo $equipo)
    {
        DB::beginTransaction();
        try {
            $nuevo_estado = null;
            $msj = 'null';
            if ($equipo->destacado == $equipo->IsDestacado()) {
                $nuevo_estado = $equipo->NoDestacado();
                $msj = 'El equipo se ha dejado de destacar';
            } else {
                $nuevo_estado = $equipo->IsDestacado();
                $msj = 'El equipo se ha destacado';
            }
            $destacados = $this->consultarCantidadDestacados()->where('n.id', $equipo->nodo_id)->where('lt.id', $equipo->lineatecnologica_id)->first();
            if ($destacados == null) {
                $destacados = 0;
            } else {
                $destacados = $destacados->cantidad;
            }
            if ($nuevo_estado == $equipo->IsDestacado() && $destacados >= config('app.equipos.num_destacados')) {
                return [
                    'state' => false,
                    'msj' => 'Excediste el límite de equipos para destacar, primero debes dejar de destacar un equipo para destacar otro, recuerdo que el límite de equipos destacados por línea es: ' . config('app.equipos.num_destacados'),
                    'type' => 'warning',
                    'title' => 'Advertencia!'
                ];
            }
            $equipo->update(['destacado' => $nuevo_estado]);
            DB::commit();
            return [
                'state' => true,
                'msj' => $msj,
                'type' => 'success',
                'title' => 'Realizado!'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'msj' => $e->getMessage(),
                'type' => 'error',
                'title' => 'Error'
            ];
        }
    }

    /**
     * Consulta la cantidad de equipos destacados de un nodo y línea
     *
     * @return type
     * @author dum
     **/
    public function consultarCantidadDestacados()
    {
        return Equipo::select('e.nombre as nodo', 'lt.nombre as linea')
        ->selectRaw('count(equipos.id) AS cantidad')
        ->join('nodos as n', 'n.id', '=', 'equipos.nodo_id')
        ->join('entidades as e', 'e.id', '=', 'n.entidad_id')
        ->join('lineastecnologicas as lt', 'lt.id', '=', 'equipos.lineatecnologica_id')
        ->where('equipos.destacado', Equipo::IsDestacado())
        ->groupBy('nodo', 'linea');
    }
}
