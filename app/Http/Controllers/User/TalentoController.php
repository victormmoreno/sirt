<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Talento};
use App\Repositories\Repository\UserRepository\{TalentoRepository, UserRepository};


class TalentoController extends Controller
{
    public $talentoRepository;
    public $userRepository;

    public function __construct(TalentoRepository $talentoRepository, UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->talentoRepository = $talentoRepository;
        $this->userRepository    = $userRepository;
    }

    /**
     * Consulta la edad de un talento
     *
     * @param int $id id del talento
     * @return int
     * @author dum
     */
    public function getEdad($id)
    {
        $talento = Talento::find($id);
        $edad = $talento->user->fechanacimiento->age;
        return $edad;
    }

    public function datatableTalentosDeTecnoparque()
    {
        if (request()->ajax()) {
            $talentos = Talento::ConsultarTalentosDeTecnoparque()
                ->get();
            return datatables()->of($talentos)->addColumn('add_proyecto', function ($data) {
                    $add = '<a onclick="addTalentoProyecto(' . $data->id . ')" class="btn bg-info white-text m-b-xs"><i class="material-icons">done</i></a>';
                    return $add;
                })->addColumn('add_propiedad', function ($data) {
                    $propiedad = '<a onclick="addPersonaPropiedad(' . $data->user_id . ')" class="btn bg-secondary m-b-xs"><i class="material-icons">done</i></a>';
                    return $propiedad;
                })
                ->addColumn('add_intertocutor_talent_articulation', function ($data) {
                    $add = '<a onclick="articulationStage.addInterlocutorTalentArticulacion(' . $data->id . ')" class="btn bg-info white-text m-b-xs"><i class="material-icons">done</i></a>';
                    return $add;
                })

                ->addColumn('add_talents_articulation', function ($data) {
                    $add = '<a onclick="filter_articulations.addTalentToArticulation(' . $data->id . ')" class="btn bg-info white-text m-b-xs"><i class="material-icons">done</i></a>';
                    return $add;
                })
                ->rawColumns(['add_proyecto', 'add_proyecto', 'add_propiedad', 'add_talents_articulation', 'add_intertocutor_talent_articulation'])->make(true);
        }
        abort('404');
    }



    public function consultarUnTalentoPorId($id)
    {
        return response()->json([
            'talento' => Talento::ConsultarTalentoPorId($id)->get()->last(),
        ]);
    }
}
