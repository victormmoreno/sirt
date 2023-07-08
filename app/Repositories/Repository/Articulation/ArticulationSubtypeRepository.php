<?php

namespace App\Repositories\Repository\Articulation;

use App\Models\ArticulationSubtype;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticulationSubtypeRepository
{
    private $strError = null;
    public function getError()
    {
        return $this->strError;
    }

    public function filterArtuculationSubtypes($request)
    {
        $articulationSubtypes = ArticulationSubtype::query()
            ->select(
                'articulation_subtypes.id as articulation_subtype_id',
                'articulation_types.name as articulation_type_name',
                'articulation_subtypes.name as articulation_subtype_name',
                'articulation_subtypes.description as articulation_subtype_description',
                'articulation_subtypes.entity as articulation_subtype_entity',
                'articulation_subtypes.state as articulation_subtype_state'
            )
            ->selectRaw(
                "DATE_FORMAT(articulation_subtypes.created_at,'%d/%m/%Y %h:%i %p') AS articulation_subtype_created_at"
            )
            ->join('articulation_types', 'articulation_types.id', '=', 'articulation_subtypes.articulation_type_id')
            ->join('articulation_subtype_node', 'articulation_subtype_node.articulation_subtype_id', '=', 'articulation_subtypes.id')
            ->join('nodos', 'nodos.id', '=', 'articulation_subtype_node.nodo_id')
            ->state($request->filter_state_artuculation_subtype)
            ->node($request->filter_node_artuculation_subtype)
            ->groupBy('articulation_subtypes.id')
            ->orderBy('articulation_subtypes.created_at', 'desc')
            ->get();
        return $this->datatableArticulationSubtypes($articulationSubtypes);
    }

    private function datatableArticulationSubtypes($articulationSubtypes)
    {
        return datatables()->of($articulationSubtypes)
            ->editColumn('articulation_subtype_created_at', function ($data) {
                if(isset($data->articulation_subtype_created_at)) {
                    return $data->articulation_subtype_created_at;
                }
                return __('No register');
            })
            ->editColumn('articulation_subtype_name', function ($data) {
                if(isset($data->articulation_subtype_name)) {
                    return Str::limit($data->articulation_subtype_name, 30);
                }
                return __('No register');
            })
            ->editColumn('articulation_subtype_description', function ($data) {
                if(isset($data->articulation_subtype_description)) {
                    return Str::limit($data->articulation_subtype_description, 30);
                }
                return __('No register');
            })
            ->editColumn('articulation_subtype_entity', function ($data) {
                if(isset($data->articulation_subtype_entity)){
                    return  json_decode($data->articulation_subtype_entity);
                }
                return __('No register');
            })
            ->editColumn('articulation_subtype_state', function ($data) {
                if($data->articulation_subtype_state == ArticulationSubtype::mostrar()){
                    return  '<div class="chip bg-success white-text">'.$data->articulation_subtype_state.'</div>';
                }else{
                    return  '<div class="chip bg-danger white-text">'.$data->articulation_subtype_state.'</div>';
                }
            })
            ->addColumn('articulation_type_name', function ($data) {
                return $data->articulation_type_name;
            })->addColumn('show', function ($data) {
                return '<a class="btn tooltipped bg-info m-b-xs modal-trigger" href='.route('tiposubarticulaciones.show', $data->articulation_subtype_id).'>
                            <i class="material-icons">search</i>
                        </a>';
            })
            ->rawColumns(['articulation_subtype_created_at', 'articulation_subtype_state', 'articulation_type_name', 'show'])->make(true);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $articulationSubtype = ArticulationSubtype::create([
                'name'          => $request->input('name'),
                'description'      => $request->input('description'),
                'state'         => $request->filled('checkestado') ? ArticulationSubtype::mostrar() : ArticulationSubtype::ocultar(),
                'entity' => explode(',', $request->input('entity')),
                'articulation_type_id' => $request->input('articulationtype'),
            ]);
            $articulationSubtype->nodos()->sync($request->input('checknode'));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            $this->strError = $e->getMessage();
            DB::rollback();
            return false;
        }
    }

    public function findById($id)
    {
        return ArticulationSubtype::query()
            ->select(
                'articulation_subtypes.id as articulation_subtype_id',
                'articulation_types.name as articulation_type_name',
                'articulation_subtypes.name as articulation_subtype_name',
                'articulation_subtypes.description as articulation_subtype_description',
                'articulation_subtypes.entity as articulation_subtype_entity',
                'articulation_subtypes.state as articulation_subtype_state'
            )
            ->selectRaw(
                "DATE_FORMAT(articulation_subtypes.created_at,'%d/%m/%Y %h:%i %p') AS articulation_subtype_created_at, DATE_FORMAT(articulation_subtypes.updated_at,'%d/%m/%Y %h:%i %p') AS articulation_subtype_updated_at, GROUP_CONCAT(DISTINCT entidades.nombre
                            ORDER BY  entidades.nombre ASC SEPARATOR ', ') as articulation_subtype_nodos"
            )
            ->join('articulation_types', 'articulation_types.id', '=', 'articulation_subtypes.articulation_type_id')
            ->join('articulation_subtype_node', 'articulation_subtype_node.articulation_subtype_id', '=', 'articulation_subtypes.id')
            ->join('nodos', 'nodos.id', '=', 'articulation_subtype_node.nodo_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->groupBy('articulation_subtypes.id')
            ->orderBy('articulation_subtypes.created_at', 'desc')
            ->findOrFail($id);
    }

    public function update($request, $articulationSubtype){
        DB::beginTransaction();
        try {
            $articulationSubtype->update([
                'name'          => $request->input('name'),
                'description'      => $request->input('description'),
                'state'         => $request->filled('checkestado') ? ArticulationSubtype::mostrar() : ArticulationSubtype::ocultar(),
                'entity' => explode(',', $request->input('entity')),
                'articulation_type_id' => $request->input('articulationtype'),
            ]);
            $articulationSubtype->nodos()->sync($request->input('checknode'));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            $this->strError = $e->getMessage();
            DB::rollback();
            return false;
        }
    }


}
