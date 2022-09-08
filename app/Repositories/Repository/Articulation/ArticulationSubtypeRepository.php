<?php

namespace App\Repositories\Repository\Articulation;

use App\Models\ArticulationSubtype;
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
            ->with('articulationtype')
            ->state($request->filter_state_artuculation_subtype)
            ->node($request->filter_node_artuculation_subtype)
            ->orderBy('created_at', 'desc')
            ->get();
        return $this->datatableArticulationSubtypes($articulationSubtypes);
    }

    private function datatableArticulationSubtypes($articulationSubtypes)
    {
        return datatables()->of($articulationSubtypes)
            ->editColumn('created_at', function ($data) {
                return $data->created_at
                    ->isoFormat('lll');
            })
            ->editColumn('name', function ($data) {
                return Str::limit($data->present()->name(), 30);
            })
            ->editColumn('description', function ($data) {
                return $data->present()->descriptionLimit();
            })
            ->editColumn('entity', function ($data) {
                return $data->entity;
            })
            ->editColumn('state', function ($data) {
                if($data->state == ArticulationSubtype::mostrar()){
                    return  '<div class="chip green white-text text-darken-2">'.$data->present()->status().'</div>';
                }
                if($data->state == ArticulationSubtype::ocultar()){
                    return  '<div class="chip red white-text text-darken-2">'.$data->present()->status().'</div>';
                }
            })
            ->addColumn('articulationtype', function ($data) {
                return $data->articulationtype->present()->name();
            })->addColumn('show', function ($data) {
                return '<a class="btn m-b-xs modal-trigger" href='.route('tiposubarticulaciones.show', $data->id).'>
                    <i class="material-icons">search</i>
                    </a>';
            })
            ->rawColumns(['created_at', 'state', 'articulationtype', 'show'])->make(true);
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
