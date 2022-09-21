<?php

namespace App\Http\Controllers\Articulation;

use App\Models\Articulation;
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
use function foo\func;

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
            if (isset($request->filter_status_articulationStage) || isset($request->filter_year_articulationStage)) {
                $articulationStages = Articulation::query()
                    ->with([
                        'phase' ,
                        'articulationstage',
                        'articulationstage.node' => function($query){
                            return $query->select(['id', 'entidad_id']);
                        },
                        'articulationstage.node.entidad' => function($query){
                            return $query->select(['id', 'nombre']);
                        },
                        'articulationstage.projects' => function($query){
                            return $query->select(['proyectos.id', 'proyectos.articulacion_proyecto_id']);
                        },
                        'articulationstage.projects.articulacion_proyecto' => function($query){
                            return $query->select(['id', 'entidad_id', 'actividad_id']);
                        },
                        'articulationstage.projects.articulacion_proyecto.actividad' => function($query){
                            return $query->select(['id', 'codigo_actividad', 'nombre']);
                        },
                        'articulationstage.interlocutor' => function($query){
                            return $query->select(['id', 'documento', 'nombres', 'apellidos', 'email']);
                        }
                    ])
                    ->articulationStageStatus($request->filter_status_articulationStage)
                    ->articulationStageYear($request->filter_year_articulationStage)
                    ->articulationStageNode($node)
                    ->articulationStageInterlocutorTalent($talent)
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
                    'node' => function($query){
                        return $query->select(['id', 'entidad_id']);
                    },
                    'node.entidad'=> function($query){
                        return $query->select(['id', 'nombre']);
                    },
                    'createdBy' => function($query){
                        return $query->select(['id', 'documento', 'nombres', 'apellidos', 'email']);
                    },
                    'articulations',
                    'projects'=> function($query){
                        return $query->select(['proyectos.id', 'proyectos.articulacion_proyecto_id']);
                    },
                    'projects.articulacion_proyecto' => function($query){
                        return $query->select(['id', 'entidad_id', 'actividad_id']);
                    },
                    'projects.articulacion_proyecto.actividad' => function($query){
                        return $query->select(['id', 'codigo_actividad', 'nombre']);
                    },
                    'interlocutor'  => function($query){
                        return $query->select(['id', 'documento', 'nombres', 'apellidos', 'email']);
                    }
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
                return "<blockquote class='orange-text text-darken-2'>{$data->articulationstage->node->present()->NodeName()}</blockquote>";
            })
            ->editColumn('articulation_name', function ($data) {
                return "<p>
                    <span class='orange-text'>{$data->code}</span><br>
                    <b>".Str::limit("{$data->name}", 40, '...')."</b>
                 </p>";
            })
            ->editColumn('articulationstate_name', function ($data) {
                return "
                <tr class='group grey lighten-2'>
                    <th >
                        {$data->articulationstage->node->present()->NodeName()}
                    </th>
                    <th>
                        <p>
                        <span class='orange-text'>{$data->articulationstage->present()->articulationStageCode()} ({$data->articulationstage->present()->articulationStageCountArticulations()})</span><br>
                        <b>".Str::limit("{$data->articulationstage->present()->articulationStageName()}", 40, '...')."</b><br>
                        <span class='orange-text'>Talento Interlocutor: </span> ".Str::limit("{$data->articulationstage->present()->articulationStageInterlocutorTalent()}", 30, '...')."
                     </p>
                    </th>
                    <th>
                        <p>
                            <span class='orange-text'>{$data->articulationstage->present()->articulationStageableType()}</span><br>
                            <b>".Str::limit("{$data->articulationstage->present()->articulationStageables()}", 40, '...')."</b><br>
                        </p>
                    </th>
                    <th>
                        <div class='chip red ". $data->articulationstage->present()->articulationStageStatusColor() ." white-text text-darken-2'>".$data->articulationstage->present()->articulationStageStatus()."</div>
                    </th>
                    </th>
                        <th>
                            {$data->articulationstage->present()->articulationStageStartDate()}
                        </th>
                    <th>
                        <a class='btn m-b-xs modal-trigger' href='".route('articulation-stage.show', $data->articulationstage->id)."'>
                            <i class='material-icons'>search</i>
                        </a>
                    </th>
                </tr>";
            })
            ->editColumn('description', function ($data) {
                return Str::limit("{$data->present()->articulationDescription()}", 40, '...');
            })
            ->editColumn('phase', function ($data) {
                return $data->present()->articulationPhase();
            })
            ->editColumn('starDate', function ($data) {
                return $data->present()->articulationStartDate();
            })->addColumn('show', function ($data) {
                return '<a class="btn m-b-xs modal-trigger" href='.route('articulations.show', $data->id).'>
                            <i class="material-icons">search</i>
                        </a>';
            })->rawColumns(['node','articulationstate_name','articulation_name','phase','starDate','show'])->make(true);
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
