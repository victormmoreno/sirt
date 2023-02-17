<?php

namespace App\Repositories\Repository\Articulation;

use App\Models\ArticulationType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ArticulationTypeRepository
{
    private $strError = null;

    public function getError()
    {
        return $this->strError;
    }

    public function filterSupports($request)
    {
        $articulationTypes = ArticulationType::query()
                        ->state($request->filter_state_type_art)
                        ->orderBy('created_at', 'desc')
                        ->get();
        return $this->datatableArticulationTypes($articulationTypes);
    }

    private function datatableArticulationTypes($articulationTypes)
    {
        return datatables()->of($articulationTypes)
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

        ->editColumn('state', function ($data) {
            if($data->state == ArticulationType::mostrar()){
                return  '<div class="chip bg-success white-text">'.$data->present()->status().'</div>';
            }else{
                return  '<div class="chip bg-danger white-text">'.$data->present()->status().'</div>';
            }
        })
        ->addColumn('show', function ($data) {
            return '<a class="btn bg-secondary m-b-xs modal-trigger" href='.route('tipoarticulaciones.show', $data).'>
                        <i class="material-icons">search</i>
                    </a>';
        })
        ->rawColumns(['created_at', 'state',  'show'])->make(true);
    }

    public function storeTypeArticulation($request){
        DB::beginTransaction();
        try {
            $typeArticulation = ArticulationType::create([
                'name'          => $request->input('name'),
                'description'      => $request->input('description'),
                'state'         => $request->filled('checkestado') ? ArticulationType::mostrar() : ArticulationType::ocultar(),
            ]);
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
                'name'          => $request->input('name'),
                'description'      => $request->input('description'),
                'state'         => $request->filled('checkestado') ? ArticulationType::mostrar() : ArticulationType::ocultar(),
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            $this->strError = $e->getMessage();
            DB::rollback();
            return false;
        }
    }
}
