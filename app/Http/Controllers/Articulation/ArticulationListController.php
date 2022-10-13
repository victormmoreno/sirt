<?php

namespace App\Http\Controllers\Articulation;

use App\Models\AlcanceArticulacion;
use App\Models\ArticulationType;
use App\Models\Fase;
use App\Repositories\Repository\Articulation\ArticulationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticulationStage;
use App\Models\Entidad;
use App\Models\Articulation;
use App\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Exports\Articulation\articulationStageExport;

class ArticulationListController extends Controller
{
    private $articulationRespository;

    public function __construct(ArticulationRepository $articulationRespository)
    {
        $this->articulationRespository = $articulationRespository;
        $this->middleware(['auth']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articulation = Articulation::query()
            ->with([
                'articulationstage'
            ])
            ->findOrfail($id);
        $traceability = Articulation::getTraceability($articulation)->get();
        return view('articulation.show-articulation', compact('articulation', 'traceability'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $phase
     * @return \Illuminate\Http\Response
     */
    public function showPhase($id, $phase)
    {
        $articulation = Articulation::query()
            ->with([
                'articulationstage'
            ])
            ->findOrfail($id);
        switch (strtoupper($phase)){
            case 'INICIO':
                $scopes = AlcanceArticulacion::orderBy('name')->pluck('name', 'id');
                $articulationTypes= ArticulationType::query()
                    ->where('state', ArticulationType::mostrar())
                    ->orderBy('name')->pluck('name', 'id');
                return view('articulation.edit-articulation', compact('articulation', 'scopes', 'articulationTypes'));
                break;
            case 'EJECUCION':
                return view('articulation.edit-articulation-execution', compact('articulation'));
                break;
            case 'CIERRE':
                return view('articulation.edit-articulation-closing', compact('articulation'));
                breaK;
            default:
                return view('articulation.edit-articulation', compact('articulation'));
                break;
        }
        return view('articulation.show-articulation', compact('articulation'));
    }

    /**
     * Display the specified resource.

     */
    public function changePhase($id, $phase)
    {
        $articulation = Articulation::query()
            ->with([
                'articulationstage'
            ])
            ->findOrfail($id);
        switch (strtoupper($phase)){
            case 'INICIO':
                return redirect()->route('articulations.show', $articulation->id);
                break;
            case 'EJECUCION':
                $articulation->update([
                   'phase_id' => Fase::where('nombre', Articulation::IsEjecucion())->first()->id
                ]);
                $comentario = 'desde inicio';
                $movimiento = \App\Models\Movimiento::IsCambiar();
                $articulation->createTraceability($movimiento,Session::get('login_role'), $comentario,strtolower($phase));
                return redirect()->route('articulations.show.phase', [$articulation, 'ejecucion']);
                break;
            case 'CIERRE':
                $articulation->update([
                    'phase_id' => Fase::where('nombre', Articulation::IsCierre())->first()->id
                ]);
                $comentario = 'desde ejecución';
                $movimiento = \App\Models\Movimiento::IsCambiar();
                $articulation->createTraceability($movimiento,Session::get('login_role'), $comentario,strtolower($phase));
                return redirect()->route('articulations.show.phase', [$articulation, 'cierre']);
                breaK;
            default:
                return redirect()->route('articulations.show', $articulation->id);
                break;
        }
    }
    public function updatePhaseExecute(Request $request,$id)
    {
        $articulation = Articulation::query()
            ->findOrfail($id);
        $response = $this->articulationRespository->updateEntregablesEjecucionRepository($request, $articulation);
        if ($response != null) {
            Alert::success('Modificación Exitosa!', 'Los entregables de la articulación en la fase de ejecución se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('articulations.show', $response->id);
        } else {
            Alert::error('Modificación Errónea!', 'Los entregables de la articulación en la fase de ejecución no se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }

        /*$articulation->update([
            'tracing' => $request->tracing,
            'announcement_document' => $request->announcement_document,
        ]);*/

    }

}
