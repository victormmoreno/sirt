<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accompaniment;
use App\Models\Entidad;
use App\User;
use Illuminate\Support\Str;

class AccompanimentListController extends Controller
{
    /**
     * method to show the list of accompaniments (index) with filters
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @author julicode
     */
    public function index(Request $request)
    {
        $nodos = Entidad::has('nodo')->orderBy('nombre')->get()->pluck('nombre', 'nodo.id');


        // return dd($accompaniments->chunk(50, function($accompaniment){

        // }));
        return view('articulation.index-accompaniment', ['nodos' => $nodos]);
    }

    public function datatableFiltros(Request $request)
    {
        // $this->authorize('datatable', ArticulacionPbt::class);
        $talent = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = $request->filter_node;
                $user = null;
                break;
            case User::IsDinamizador():
                $node = auth()->user()->dinamizador->nodo_id;
                $user = null;
                break;
            case User::IsArticulador():
                $node = auth()->user()->articulador->nodo_id;
                $user = auth()->user()->id;
                break;
            case User::IsTalento():
                $node = null;
                $user = null;
                $talent = auth()->user()->id;
                break;
            default:
                return abort('403');
                break;
        }

        $accompaniments = [];
        if (!empty($request->filter_year) && !empty($request->filter_status)) {

            $accompaniments =  Accompaniment::with([
                'node',
                'node.entidad'
            ])
            ->year($request->filter_year)
            ->status($request->filter_status)
            ->node($node)
            ->interlocutorTalent($talent)
            ->orderBy('created_at', 'desc')
            ->get();
        }
        return $this->datatableAccompaniments($accompaniments);
    }

    private function datatableAccompaniments($accompaniments)
    {
        return datatables()->of($accompaniments)
        ->editColumn('node', function ($data) {
            if (isset($data->node->entidad)) {
                return $data->node->entidad->nombre;
            }
            return "No registra";
        })
        ->editColumn('code', function ($data) {
            if (isset($data->code)) {
                return $data->code;
            }
            return "No registra";
        })
        ->editColumn('name', function ($data) {
            if (isset($data->name)) {
                return Str::limit("{$data->name}", 40, '...');
            }
            return "No registra";
        })
        ->editColumn('count_articulations', function ($data) {
            if (isset($data->articulations_count)) {
                return "{$data->articulations_count}";
            }
            return 0;
        })
        ->editColumn('status', function ($data) {
            if (isset($data->status)) {
                return $data->status;
            }
            return "No registra";
        })
        ->editColumn('starDate', function ($data) {
            if (isset($data->created_at)) {
                return  $data->created_at->isoFormat('DD/MM/YYYY');
            }
            return "No registra";


        })->addColumn('show', function ($data) {
            $info = '<a class="btn m-b-xs modal-trigger" href='.route('articulation.accompaniments.show', $data->id).'>
            <i class="material-icons">search</i>
            </a>';
                return $info;
        })->rawColumns(['node','code','name','adviser','status','starDate','show'])->make(true);
    }


}
