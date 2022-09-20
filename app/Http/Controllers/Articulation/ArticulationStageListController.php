<?php

namespace App\Http\Controllers\Articulation;

use App\Models\Nodo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticulationStage;
use App\User;
use Illuminate\Support\Str;
use App\Exports\Articulation\articulationStageExport;
use App\Repositories\Repository\Articulation\ArticulationStageRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ArticulationStageListController extends Controller
{
    private $articulationStageRepository;
    public function __construct(ArticulationStageRepository $articulationStageRepository)
    {
        $this->articulationStageRepository = $articulationStageRepository;
        $this->middleware(['auth']);
    }
    /**
     * method to show the list of articulationStages (index) with filters
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->user()->can('index', ArticulationStage::class)) {
            $nodos = null;
            if(request()->user()->can('listNodes', ArticulationStage::class)) {
                $nodos = Nodo::query()->with('entidad')->get();
                $nodos = collect($nodos)->sortBy('entidad.nombre')->pluck('entidad.nombre', 'id');
            }
            return view('articulation.index-articulation-stage', ['nodos' => $nodos]);
        }
        return redirect()->route('home');
    }

    /**
     * method to show return the datatables ArticulationStages
     * @return \Illuminate\Http\Response
     */
    public function datatableFiltros(Request $request)
    {
        if (request()->ajax() && request()->user()->can('index', ArticulationStage::class)) {
            $talent = $this->checkRoleAuth($request)['talent'];
            $node = $this->checkRoleAuth($request)['node'];
            $articulationStages = [];
            if (isset($request->filter_status_articulationStage)) {
                $articulationStages = ArticulationStage::query()
                    ->with([
                        'node.entidad',
                        'createdBy',
                        'projects.articulacion_proyecto.actividad',
                        'interlocutor'
                    ])
                    ->status($request->filter_status_articulationStage)
                    ->year($request->filter_year_articulationStage)
                    ->node($node)
                    ->interlocutorTalent($talent)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return $this->datatablearticulationStages($articulationStages);
        }
        return redirect()->route('home');
    }

    /**
     * method to download the list of articulation stages
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $extension = 'xlsx')
    {
        if (request()->user()->can('downloadReports', ArticulationStage::class)) {
            $talent = $this->checkRoleAuth($request)['talent'];
            $node = $this->checkRoleAuth($request)['node'];

            $articulationStages = [];
            if (isset($request->filter_status_articulationStage)) {

                $articulationStages = ArticulationStage::with([
                    'node.entidad',
                    'createdBy',
                    'articulations',
                    'projects.articulacion_proyecto.actividad',
                    'interlocutor'
                ])
                    ->status($request->filter_status_articulationStage)
                    ->year($request->filter_year_articulationStage)
                    ->node($node)
                    ->interlocutorTalent($talent)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return (new articulationStageExport($articulationStages))->download(__('articulation-stage') .' - '. config('app.name') . ".{$extension}");
        }
        return redirect()->route('home');
    }

    /**
     * method to delete system file
     * @param int id
     * @return Response
     */
    public function destroyFile($id)
    {
        if (request()->user()->can('destroyFile', ArticulationStage::class)) {
            $response = $this->articulationStageRepository->destroyFile($id);
            if ($response) {
                toast('El Archivo se ha eliminado con éxito!', 'success')->autoClose(2000)->position('top-end');
                return back();
            }
            toast('El Archivo no se ha eliminado!', 'danger')->autoClose(2000)->position('top-end');
            return back();
        }
        return redirect()->route('home');
    }

    /**
     * method to download a file from the system
     * @return \Illuminate\Http\Response
     */
    public function downloadFile($articulationStage)
    {
        if (request()->user()->can('downloadFile', ArticulationStage::class)) {
            $articulationStage = ArticulationStage::query()->findOrFail($articulationStage);
            return $this->articulationStageRepository->downloadFile($articulationStage);
        }
        return redirect()->route('home');
    }

    /**
     * Display the specified resource for change the interlocutor talent of an articulation stage.
     *
     * @param  int  $articulationStage
     * @return \Illuminate\Http\Response
     */
    public function changeInterlocutor($articulationStage)
    {
        $articulationStage = ArticulationStage::query()->findOrFail($articulationStage);
        if (request()->user()->can('changeTalent', $articulationStage)) {

            return view('articulation.change-interlocutor', compact('articulationStage'));
        }
        return redirect()->route('home');

    }

    /**
     * method to change the interlocutor talent of an articulation stage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $articulationStage
     */
    public function updateInterlocutor(Request $request, $articulationStage)
    {
        $articulationStage = ArticulationStage::query()->findOrFail($articulationStage);
        if (request()->user()->can('changeTalent', $articulationStage)) {

            $validator = Validator::make($request->all(), [
                'talent' => 'required'
            ], [
                'talent' => 'Debes seleccionar por lo menos un talento interlocutor'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'state' => 'error_form',
                    'errors' => $validator->errors(),
                ]);
            } else {
                $response = $this->articulationStageRepository->updateInterlocutor($request, $articulationStage);
                if ($response["isCompleted"]) {
                    return response()->json([
                        'data' => [
                            'state' => 'success',
                            'url' => route('articulation-stage.show', $response['data']->id),
                            'status_code' => Response::HTTP_CREATED,
                            'errors' => [],
                        ],
                    ], Response::HTTP_CREATED);
                } else {
                    return response()->json([
                        'data' => [
                            'state' => 'danger',
                            'errors' => [],
                        ],
                    ]);
                }
            }
            return redirect()->route('home');
        }
    }

    /**
     * method to return the structure of the datatables ArticulationStages
     * @return void
     */
    private function datatableArticulationStages($articulationStages)
    {
        return datatables()->of($articulationStages)
            ->editColumn('node', function ($data) {
                return $data->node->present()->NodeName();
            })
            ->editColumn('name', function ($data) {
                return "<p>
                            <span class='orange-text'>{$data->present()->articulationStageCode()}</span><br>
                            <b>".Str::limit("{$data->present()->articulationStageName()}", 40, '...')."</b><br>
                            <span class='orange-text'>Talento Interlocutor: </span> ".Str::limit("{$data->present()->articulationStageInterlocutorTalent()}", 30, '...')."
                        </p>";
            })
            ->editColumn('articulation_state_type', function ($data) {
                return "<p>
                            <span class='orange-text'>{$data->present()->articulationStageableType()}</span><br>
                            <b>".Str::limit("{$data->present()->articulationStageables()}", 40, '...')."</b><br>
                        </p>";
            })
            ->editColumn('count_articulations', function ($data) {
                if (isset($data->articulations_count)) {
                    return "{$data->articulations_count}";
                }
                return 0;
            })
            ->editColumn('status', function ($data) {
                if($data->status == ArticulationStage::STATUS_OPEN){
                    return  '<div class="chip green white-text text-darken-2">'.$data->present()->articulationStageStatus().'</div>';
                }
                if($data->status == ArticulationStage::STATUS_CLOSE){
                    return  '<div class="chip red white-text text-darken-2">'.$data->present()->articulationStageStatus().'</div>';
                }
            })
            ->editColumn('articulationStageBy', function ($data) {
                return $data->present()->articulationStageBy();
            })
            ->editColumn('starDate', function ($data) {
                return $data->present()->articulationStageStartDate();
            })->addColumn('show', function ($data) {
                return '<a class="btn m-b-xs modal-trigger" href='.route('articulation-stage.show', $data->id).'>
                            <i class="material-icons">search</i>
                        </a>';
            })->rawColumns(['node','code','name','adviser','status','starDate','articulationStageBy','articulation_state_type','show'])->make(true);
    }

    /**
     * method to validate the authenticated role
     * @return void
     */
    private function checkRoleAuth(Request $request)
    {
        $talent = null;
        $node = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = $request->filter_node_articulationStage;
                break;
            case User::IsActivador():
                $node = $request->filter_node_articulationStage;
                break;
            case User::IsDinamizador():
                $node = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsArticulador():
                $node = auth()->user()->articulador->nodo_id;
                break;
            case User::IsTalento():
                $node = null;
                $talent = auth()->user()->id;
                break;
            default:
                $talent = null;
                $node = null;
                break;
        }
        return ['talent' => $talent, 'node' => $node];
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articulationStage = ArticulationStage::query()
            ->with([
                'node.entidad',
                'createdBy',
                'articulations.phase',
                'projects.articulacion_proyecto.actividad',
                'file',
                'interlocutor'
            ])
        ->findOrfail($id);



        if (request()->user()->can('show', $articulationStage)) {

            $ult_notificacion = $this->articulationStageRepository->retornarUltimaNotificacionPendiente($articulationStage);

            // $rol_destinatario = $this->proyectoRepository->verificarDestinatarioNotificacion($ult_notificacion);

            return view('articulation.show-articulation-stage', compact('articulationStage', 'ult_notificacion'));
        }
        return redirect()->route('home');

    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $articulationStage
     */
    public function destroy($articulationStage)
    {
        $articulationStage = ArticulationStage::findOrFail($articulationStage);
        if (request()->user()->can('delete', $articulationStage)) {
            if (!$articulationStage->articulations->IsEmpty()) {
                return response()->json([
                    'fail' => true,
                    'redirect_url' => route('articulation-stage.show', $articulationStage->id),
                ]);
            }
            if (isset($articulationStage->projects)) {
                $articulationStage->projects()->detach();
            }
            if (isset($articulationStage->articulations->users)) {
                $articulationStage->articulations()->delete();
                $articulationStage->articulations->users()->detach();
            }
            if (isset($articulationStage->file)) {
                $filePath = str_replace('storage', 'public', $articulationStage->file->ruta);
                Storage::delete($filePath);
                $articulationStage->file()->delete();
            }
            $articulationStage->delete();
            return response()->json([
                'fail' => false,
                'redirect_url' => route('articulation-stage'),
            ]);
        }
    }
}
