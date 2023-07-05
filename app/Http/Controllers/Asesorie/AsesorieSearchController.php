<?php

namespace App\Http\Controllers\Asesorie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Asesorie\AsesorieSearchRequest;
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
    public function querySearchUser(Request $request)
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
        $asesories = $this->asesorieRepository->queryAsesorieSearch(($request->input('type_search') == 1 ? 'documento': 'email'),'LIKE',("%".$request->input('search_asesorie')."%"))->get();
        if(empty($users)){
            return response()->json([
                'users' => null,
                'status' => Response::HTTP_ACCEPTED,
                'message' => 'el usuario no existe en nuestros registros',
                'url' => route('registro'),
            ], Response::HTTP_ACCEPTED);
        }
        $urls = [];
        foreach($asesories as $asesorie){
            $urls[] = route('asesorias.show', $asesorie->codigo);
        };
        return response()->json([
            'users' => $users,
            'message' => 'el usuario ya existe en nuestros registros',
            'status' => Response::HTTP_OK,
            'urls' => $urls,
        ], Response::HTTP_OK);
    }
}
