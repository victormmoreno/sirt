<?php

namespace App\Http\Controllers\Asesorie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Asesorie\AsesorieSearchRequest;
use App\Models\Articulacion;
use App\Models\Articulation;
use App\Models\UsoInfraestructura;
use App\Repositories\Repository\AsesorieRepository;
use App\User;

class AsesorieSearchController extends Controller
{
    private $asesorieRepository;
    public function __construct(
        AsesorieRepository $asesorieRepository
    ) {
        $this->asesorieRepository = $asesorieRepository;
    }
    /**
     * Display the view for to search specified resource (user).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function showFormSearch()
    {
        // if (request()->user()->cannot('search', User::class)) {
        //     alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
        //     return redirect()->route('home');
        // }
        $modules = [];
        // if(request()->user()->can('moduleType', UsoInfraestructura::class)) {
            switch(session()->get('login_role')){
                case User::IsAdministrador():
                    $modules = [
                        // 'BetweenDateAsesorie' => "Entre fechas de asesorias",
                        class_basename(UsoInfraestructura::class) => "Código Asesoria",
                        class_basename(Proyecto::class) => 'Código '.__('Projects'),
                        class_basename(Articulation::class) => 'Código '.__('Articulations'),
                        class_basename(Idea::class) => 'Código '.__('Ideas')
                    ];
                    break;
                case User::IsActivador():
                    $modules = [
                        class_basename(UsoInfraestructura::class) => "Código Asesoria",
                        class_basename(Proyecto::class) => 'Código '.__('Projects'),
                        class_basename(Articulation::class) => 'Código '.__('Articulations'),
                        class_basename(Idea::class) => 'Código '.__('Ideas')
                    ];
                    break;
                case User::IsDinamizador():
                    $modules = [
                        class_basename(UsoInfraestructura::class) => "Código Asesoria",
                        class_basename(Proyecto::class) => 'Código '.__('Projects'),
                        class_basename(Articulation::class) => 'Código '.__('Articulations'),
                        class_basename(Idea::class) => 'Código '.__('Ideas')
                    ];
                    break;
                case User::IsExperto():
                    $modules = [
                        class_basename(UsoInfraestructura::class) => "Código Asesoria",
                        class_basename(Proyecto::class) => 'Código '.__('Projects'),
                    ];
                    break;
                case User::IsArticulador():
                    $modules = [
                        class_basename(UsoInfraestructura::class) => "Código Asesoria",
                        class_basename(Articulation::class) => 'Código '.__('Articulations'),
                        class_basename(Idea::class) => 'Código '.__('Ideas')
                    ];
                    break;
                case User::IsTalento():
                    $modules = [
                        class_basename(UsoInfraestructura::class) => "Código Asesoria",
                        class_basename(Proyecto::class) => 'Código '.__('Projects'),
                        class_basename(Articulation::class) => 'Código '.__('Articulations')
                    ];
                    break;
                default:
                    $modules = [];
                    break;
            }
        // }
        return view('asesorias.search', [
            'modules' => $modules
        ]);
    }

    /**
     * Search specified resource (user).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function queryAsesorieSearch(Request $request)
    {
        if (!request()->ajax() || request()->user()->cannot('search', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $req = new AsesorieSearchRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors(),
            ]);
        }
        $model = $this->checkRoleAuth($request)['model'];


        $asesories = $this->asesorieRepository->getListAsesories()
            ->selectAsesoria($model)
            ->joins($model)
            ->where(function($subquery) use($model, $request){
                if($model == class_basename(UsoInfraestructura::class)){
                    $subquery->where('usoinfraestructuras.codigo', 'LIKE', "%$request->search_asesorie%");
                }else if($model == class_basename(Proyecto::class)){
                    $subquery->where('proyectos.codigo_proyecto', 'like', "%$request->search_asesorie%");
                }else if($model == class_basename(Articulation::class)){
                    $subquery->where('articulations.code', 'like', "%$request->search_asesorie%");
                }else if($model == class_basename(Idea::class)){
                    $subquery->where('ideas.codigo_idea', 'like', "%$request->search_asesorie%");
                }
            })
            ->groupBy('usoinfraestructuras.id')
            ->get();
        if(empty($asesories)){
            return response()->json([
                'users' => null,
                'status' => Response::HTTP_ACCEPTED,
                'message' => 'No se encontraron asesorias asociadas al valor ingresado',
                'url' => route('registro'),
            ], Response::HTTP_ACCEPTED);
        }
        $urls = [];
        foreach($asesories as $asesorie){
            $urls[] = route('asesorias.show', $asesorie->codigo);
        };
        return response()->json([
            'asesories' => $asesories   ,
            'message' => "tienes {$asesories->count()} asesorias",
            'status' => Response::HTTP_OK,
            'urls' => $urls,
        ], Response::HTTP_OK);
    }

    /**
     * method to validate the authenticated role
     * @return void
     */
    private function checkRoleAuth($request)
    {
        $user = null;
        $model = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = null;
                $model = $request->type_search;
                break;
            case User::IsActivador():
                $node = null;
                $model = $request->type_search;
                break;
            case User::IsDinamizador():
                $node = [auth()->user()->dinamizador->nodo_id];
                $model = $request->type_search;
                break;
            case User::IsArticulador():
                $node = [auth()->user()->articulador->nodo_id];
                $model = $request->type_search;
                break;
            case User::IsExperto():
                $node = [auth()->user()->experto->nodo_id];
                $user = auth()->user()->id;
                $model = class_basename(Proyecto::class);
                break;
            case User::IsApoyoTecnico():
                $node = [auth()->user()->apoyotecnico->nodo_id];
                $user = auth()->user()->id;
                $model = class_basename(Proyecto::class);
                break;
            case User::IsTalento():
                $node = null;
                $user = auth()->user()->id;
                $model = $request->type_search;
                break;
            default:
                $user = null;
                $node = null;
                $model = null;
                break;
        }
        return ['user' => $user, 'node' => $node, 'model' => $model];
    }
}
