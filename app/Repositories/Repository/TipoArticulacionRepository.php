<?php

namespace App\Repositories\Repository;

use App\Models\TipoArticulacion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TipoArticulacionRepository
{
    private $strError = null;

    public function getError()
    {
        return $this->strError;
    }

    public function filterSupports($request)
    {
        $typeArts = TipoArticulacion::node($request->filter_nodo_type_art)
                        ->state($request->filter_state_type_art)
                        ->orderBy('tipo_articulaciones.created_at', 'desc')
                        ->get();

        return $this->datatableTipoArticulacion($typeArts);
    }

    private function datatableTipoArticulacion($typeArts)
    {
        return datatables()->of($typeArts)
        ->editColumn('created_at', function ($data) {
            return $data->created_at
            // ->settings(['formatFunction' => 'translatedFormat'])
            ->isoFormat('lll');
        })
        ->editColumn('nombre', function ($data) {
            return Str::limit($data->present()->nombre(), 30);
        })
        ->editColumn('descripcion', function ($data) {
            return $data->present()->descripcionLimit();
        })
        ->editColumn('entidad', function ($data) {
            return $data->present()->entidad();
        })

        ->editColumn('estado', function ($data) {
            if($data->estado == TipoArticulacion::mostrar()){
                return  '<div class="chip green white-text text-darken-2">'.$data->present()->estado().'</div>';
            }
            if($data->estado == TipoArticulacion::ocultar()){
                return  '<div class="chip red white-text text-darken-2">'.$data->present()->estado().'</div>';
            }

        })
        ->addColumn('show', function ($data) {
            return '<a class="btn m-b-xs modal-trigger" href='.route('tipoarticulaciones.show', $data->id).'>
            <i class="material-icons">search</i>
            </a>';
        })
        ->rawColumns(['created_at', 'estado',  'show'])->make(true);
    }

    public function storeTypeArticulation($request){
        DB::beginTransaction();
        try {

            $typeArticulation = TipoArticulacion::create([
                'nombre'          => $request->input('txtnombre'),
                'descripcion'      => $request->input('txtdescripcion'),
                'entidad'      => $request->input('txtentidad'),
                'estado'         => $request->filled('checkestado') ? TipoArticulacion::mostrar() : TipoArticulacion::ocultar(),
            ]);

            $typeArticulation->nodos()->sync($request->input('checknode'));

            DB::commit();
            return true;
        } catch (\Exception $e) {
            $this->strError = $e->getMessage();
            DB::rollback();
            return false;
        }
    }

    public function updateTypeArticulation($request, $typeArticulation){
        DB::beginTransaction();
        try {

            $typeArticulation->update([
                'nombre'          => $request->input('txtnombre'),
                'descripcion'      => $request->input('txtdescripcion'),
                'entidad'      => $request->input('txtentidad'),
                'estado'         => $request->filled('checkestado') ? TipoArticulacion::mostrar() : TipoArticulacion::ocultar(),
            ]);

            $typeArticulation->nodos()->sync($request->input('checknode'));

            DB::commit();
            return true;
        } catch (\Exception $e) {
            $this->strError = $e->getMessage();
            DB::rollback();
            return false;
        }
    }
}
