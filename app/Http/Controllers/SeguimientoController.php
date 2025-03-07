<?php

namespace App\Http\Controllers;

use App\Models\{Gestor, Nodo, Proyecto, Articulation};
use App\Repositories\Repository\Articulation\ArticulationRepository;
use App\Repositories\Repository\{ProyectoRepository, LineaRepository};
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use Illuminate\Support\Str;

class SeguimientoController extends Controller
{

    /**
     * Objeto para la clase ProyectoRepository
     * @var object
     */
    private $proyectoRepository;
    /**
     * Objeto para la clade LineaRepository
     *
     * @var object
     */
    private $lineaRepository;

    private $articulationRepository;

    public function __construct(ProyectoRepository $proyectoRepository, LineaRepository $lineaRepository, ArticulationRepository $articulationRepository)
    {
        $this->setProyectoRepository($proyectoRepository);
        $this->setLineaRepository($lineaRepository);
        $this->articulationRepository = $articulationRepository;
    }

    /**
     * Agreupa por fases la cantidad de proyectos
     *
     * @param Builder $Pabiertos Query de los proyectos por fases (Inicio, Planeación, Ejecución, Cierre)
     * @return array
     * @author dum
     **/
    public function agruparProyectos($Pabiertos, $Pfinalizados)
    {
        $datos = [];
        $temporal = $Pabiertos->groupBy('nombre');
        foreach ($temporal as $row) {
            $cnt_inicio = $Pabiertos->where('nombre', $row->first()->nombre)->where('fase', 'Inicio')->first();
            $cnt_planeacion = $Pabiertos->where('nombre', $row->first()->nombre)->where('fase', 'Planeación')->first();
            $cnt_ejecucion = $Pabiertos->where('nombre', $row->first()->nombre)->where('fase', 'Ejecución')->first();
            $cnt_cierre = $Pabiertos->where('nombre', $row->first()->nombre)->where('fase', 'Cierre')->first();
            $cnt_fin = $Pfinalizados->where('nombre', $row->first()->nombre)->where('fase', 'Finalizado')->first();
            $cnt_suspendido = $Pfinalizados->where('nombre', $row->first()->nombre)->where('fase', 'Cancelado')->first();

            $cnt_inicio != null ? $cnt_inicio = $cnt_inicio->trl_esperado : $cnt_inicio = 0;
            $cnt_planeacion != null ? $cnt_planeacion = $cnt_planeacion->trl_esperado : $cnt_planeacion = 0;
            $cnt_ejecucion != null ? $cnt_ejecucion = $cnt_ejecucion->trl_esperado : $cnt_ejecucion = 0;
            $cnt_cierre != null ? $cnt_cierre = $cnt_cierre->trl_esperado : $cnt_cierre = 0;
            $cnt_fin != null ? $cnt_fin = $cnt_fin->cantidad : $cnt_fin = 0;
            $cnt_suspendido != null ? $cnt_suspendido = $cnt_suspendido->cantidad : $cnt_suspendido = 0;

            $datos[] = [
                'nodo' => $row->first()->nombre,
                'inicio' => $cnt_inicio,
                'planeacion' => $cnt_planeacion,
                'ejecucion' => $cnt_ejecucion,
                'cierre' => $cnt_cierre,
                'finalizado' => $cnt_fin,
                'suspendido' => $cnt_suspendido
            ];
        }
        return $datos;
    }

    /**
     * Agrupar la información de los proyectos esptados por trl
     *
     * @param $trl6
     * @param $trl7_8
     * @return array
     * @author dum
     **/
    public function agruparProyectosEsperados($trl6, $trl7_8)
    {
        $datos = [];
        $nodos = Nodo::SelectNodo()->select('entidades.nombre')->get();
        foreach ($nodos as $nodo) {
            $nodo_str = $nodo->nombre;
            $cnt_trl6 = $trl6->where('nombre', $nodo_str)->first();
            $cnt_trl7_8 = $trl7_8->where('nombre', $nodo_str)->first();

            $cnt_trl6 != null ? $cnt_trl6 = $cnt_trl6->trl_esperado : $cnt_trl6 = 0;
            $cnt_trl7_8 != null ? $cnt_trl7_8 = $cnt_trl7_8->trl_esperado : $cnt_trl7_8 = 0;

            $datos[] = [
                'nodo' => $nodo_str,
                'trl6' => $cnt_trl6,
                'trl7_8' => $cnt_trl7_8
            ];
        }
        return $datos;
    }

    /**
     * Retorna array con los valores de la cantidad de trl esperado/obtenido
     * @param Collection $proyectos
     * @param string $trl Indica si se van a contar los trl esperados u obtenidos
     * @return array
     * @author dum
     **/
    public function agruparTrls($proyectos, $trl)
    {
        $total = 0;
        $trl6 = 0;
        $trl7_8 = 0;
        $trl8 = 0;
        if ($trl == 'esperados') {
            foreach ($proyectos as $key => $value) {
                if ($value->trl_esperado == 0) {
                    $trl6++;
                } else {
                    $trl7_8++;
                }
                $total++;
            }
        } else {
            foreach ($proyectos as $key => $value) {
                if ($value->trl_obtenido == 0) {
                    $trl6 = $value->cantidad;
                } elseif ($value->trl_obtenido == 1) {
                    $trl7_8 = $value->cantidad;
                } else {
                    $trl8 = $value->cantidad;
                }
            }
        }
        return array('trl6' => $trl6, 'trl7_8' => $trl7_8, 'trl8' => $trl8, 'total' => $total);
    }

    /**
     * Retorna un array con los valores del seguimiento
     * @param array $trlsEsperados Valor entero de agrupacion de proyectos por trls esperados
     * @return array
     * @author dum
     */
    private function retornarValoresDelSeguimientoEsperados($trlsEsperados)
    {
        $datos = array();
        $datos['Activos'] = $trlsEsperados['total'];
        $datos['Esperado6'] = $trlsEsperados['trl6'];
        $datos['Esperado7_8'] = $trlsEsperados['trl7_8'];
        return $datos;
    }

    /**
     * Retorna un array con los valores del seguimiento por fase actual
     * @param array $abiertos Array con los totales de proyectos activos
     * @param array $cerrados Array con los totales de proyectos cerrados
     * @return array
     */
    private function retornarValoresDelSeguimientoPorFases($abiertos, $cerrados)
    {
        $datos = array();
        $datos['Inicio'] = $abiertos['inicio'];
        $datos['Planeacion'] = $abiertos['planeacion'];
        $datos['Ejecucion'] = $abiertos['ejecucion'];
        $datos['Cierre'] = $abiertos['cierre'];
        $datos['Finalizado'] = $cerrados['finalizado'];
        $datos['Suspendido'] = $cerrados['suspendido'];
        return $datos;
    }

    /**
     * Consulta el seguimiento de una línea de un nodo
     *
     * @param int $linea Id de la linea_tecnologica
     * @param string $fecha_inicio Primera fecha para realizar el filtro del seguimiento
     * @param string $fecha_fin Segunda fecha para realizar el filtro del seguimiento
     * @return Reponse
     * @author dum
     */
    public function seguimientoEsperadoDeLaLinea($idlinea, $idnodo)
    {
        if (Session::get('login_role') == User::IsDinamizador()) {
            $idnodo = auth()->user()->dinamizador->nodo_id;
        }
        if (Session::get('login_role') == User::IsExperto()) {
            $idnodo = auth()->user()->experto->nodo_id;
        }

        $datos = array();
        $trlEsperados = 0;
        $trlEsperados = $this->getProyectoRepository()->proyectosSeguimientoAbiertos('trl_esperado')->where('lineastecnologicas.id', $idlinea)->where('nodos.id', $idnodo)->get();
        $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'esperados');

        $datos = $this->retornarValoresDelSeguimientoEsperados($trlEsperadosAgrupados);

        return response()->json([
            'datos' => $datos
        ]);
    }

    /**
     * Consulta el seguimiento de un gestor
     *
     * @param int $id Id del gestor
     * @param string $fecha_inicio Primera fecha para realizar el filtro del seguimiento
     * @param string $fecha_fin Segunda fecha para realizar el filtro del seguimiento
     * @return Reponse
     * @author dum
     */
    public function seguimientoEsperadoDelGestor($id)
    {
        $gestor = Gestor::find($id);
        $idgestor = $gestor->id;
        $idnodo = $gestor->nodo_id;

        $datos = array();
        $trlEsperados = 0;
        $trlEsperados = $this->getProyectoRepository()->proyectosSeguimientoAbiertos('trl_esperado')->where('g.id', $idgestor)->where('nodos.id', $idnodo)->get();
        $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'esperados');
        $datos = $this->retornarValoresDelSeguimientoEsperados($trlEsperadosAgrupados);
        return response()->json([
            'datos' => $datos
        ]);
    }

    /**
     * Consulta el seguimiento de un nodo
     * @param int $id Id del nodo
     * @param string $fecha_inicio Primera fecha para realizar el filtro del seguimiento
     * @param string $fecha_fin Segunda fecha para realizar el filtro del seguimiento
     * @return Response
     * @author dum
     */
    public function seguimientoEsperado(Request $request)
    {
        if ($request->nodos[0] != 'all') {
            if (Str::contains(session()->get('login_role'), [User::IsActivador(), User::IsAdministrador()])) {
                $nodos = $request->nodos;
            } else {
                $nodos = [request()->user()->getNodoUser()];
            }
        } else {
            $nodos_temp = Nodo::SelectNodo()->get();
            foreach ($nodos_temp as $nodo) {
                $nodos[] = $nodo->id;
            }
        }

        $datos = array();
        $trlEsperados_6 = $this->getProyectoRepository()->proyectosSeguimientoAbiertos()->select('entidades.nombre')->selectRaw('count(trl_esperado) as trl_esperado')->where('trl_esperado', Proyecto::IsTrl6Esperado())->whereIn('nodos.id', $nodos)->groupBy('entidades.nombre')->get();
        $trlEsperados_7_8 = $this->getProyectoRepository()->proyectosSeguimientoAbiertos()->select('entidades.nombre')->selectRaw('count(trl_esperado) as trl_esperado')->where('trl_esperado', Proyecto::IsTrl78Esperado())->whereIn('nodos.id', $nodos)->groupBy('entidades.nombre')->get();
        $datos = $this->agruparProyectosEsperados($trlEsperados_6, $trlEsperados_7_8);
        return response()->json([
            'datos' => $datos
        ]);
    }


    public function seguimientoEsperadoDeTecnoparque()
    {
        $datos = array();
        $trlEsperados = 0;
        $trlEsperados = $this->getProyectoRepository()->proyectosSeguimientoAbiertos('trl_esperado')->get();
        $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'esperados');

        $datos = $this->retornarValoresDelSeguimientoEsperados($trlEsperadosAgrupados);

        return response()->json([
            'datos' => $datos
        ]);
    }

    /**
     * Consulta el seguimiento de un nodo, por fases actuales
     * @param int $id Id del nodo
     * @return Response
     * @author dum
     **/
    public function seguimientoDelNodoFases(Request $request)
    {
        if ($request->nodos[0] != 'all') {
            if (Str::contains(session()->get('login_role'), [User::IsActivador(), User::IsAdministrador()])) {
                $nodos = $request->nodos;
            } else {
                $nodos = [request()->user()->getNodoUser()];
            }
        } else {
            $nodos_temp = Nodo::SelectNodo()->get();
            foreach ($nodos_temp as $nodo) {
                $nodos[] = $nodo->id;
            }
        }
        $Pabiertos = 0;
        $Pfinalizados = 0;
        $Pabiertos = $this->getProyectoRepository()->proyectosSeguimientoAbiertos()->select('entidades.nombre', 'fases.nombre as fase')->selectRaw('count(trl_esperado) as trl_esperado')->groupBy('entidades.nombre', 'fase')->whereIn('nodos.id', $nodos)->get();
        $Pfinalizados = $this->getProyectoRepository()->proyectosSeguimientoCerrados(Carbon::now()->isoFormat('YYYY'))->whereIn('nodos.id', $nodos)->get();
        $agrupados = $this->agruparProyectos($Pabiertos, $Pfinalizados);
        return response()->json([
            'datos' => $agrupados
        ]);
    }

    /**
     * Consulta el seguimiento de articulaciones por nodo, por fases actuales
     * @return Response
     **/
    public function seguimientoArticulacionesDelNodoFases(Request $request)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if ($request->nodos[0] != 'all') {
            if (Str::contains(session()->get('login_role'), [User::IsActivador(), User::IsAdministrador()])) {
                $nodos = $request->nodos;
            } else {
                $nodos = [request()->user()->getNodoUser()];
            }
        } else {
            $nodos_temp = Nodo::SelectNodo()->get();
            foreach ($nodos_temp as $nodo) {
                $nodos[] = $nodo->id;
            }
        }

        $firstQuery = Articulation::query()
            ->select('fases.nombre AS fase', 'entidades.nombre as nodo')
            ->selectRaw('count(articulations.id) AS cantidad')
            ->join('articulation_stages', 'articulation_stages.id', '=', 'articulations.articulation_stage_id')
            ->join('nodos', 'nodos.id', '=', 'articulation_stages.node_id')
            ->join('fases', 'fases.id', '=', 'articulations.phase_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->whereIn('fases.nombre', [Articulation::IsFinalizado(), 'Cancelado'])
            ->whereYear('articulations.end_date', 2024)
            ->whereIn('nodos.id', $nodos)
            ->groupBy('entidades.nombre', 'fase');

        $secondQuery = Articulation::query()
            ->select('fases.nombre AS fase', 'entidades.nombre as nodo')
            ->selectRaw('count(articulations.id) AS cantidad')
            ->join('articulation_stages', 'articulation_stages.id', '=', 'articulations.articulation_stage_id')
            ->join('nodos', 'nodos.id', '=', 'articulation_stages.node_id')
            ->join('fases', 'fases.id', '=', 'articulations.phase_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->whereIn('fases.nombre', [
                Articulation::IsInicio(),
                Articulation::IsEjecucion(),
                Articulation::IsCierre()
            ])
            ->whereIn('nodos.id', $nodos)
            ->groupBy('entidades.nombre', 'fase');

        $combinedQuery = $firstQuery->unionAll($secondQuery)->get();

        return response()->json([
            'datos' => $this->agruparArticulaciones($combinedQuery)
        ]);
    }

    public function agruparArticulaciones($combinedQuery)
    {
        $datos = [];
        $temporal = $combinedQuery->groupBy('nodo');
        foreach ($temporal as $row) {
            $cnt_inicio = $combinedQuery->where('nodo', $row->first()->nodo)->where('fase', 'Inicio')->first();
            $cnt_ejecucion = $combinedQuery->where('nodo', $row->first()->nodo)->where('fase', 'Ejecución')->first();
            $cnt_cierre = $combinedQuery->where('nodo', $row->first()->nodo)->where('fase', 'Cierre')->first();
            $cnt_fin = $combinedQuery->where('nodo', $row->first()->nodo)->where('fase', 'Finalizado')->first();
            $cnt_suspendido = $combinedQuery->where('nodo', $row->first()->nodo)->where('fase', 'Cancelado')->first();

            $cnt_inicio != null ? $cnt_inicio = $cnt_inicio->cantidad : $cnt_inicio = 0;

            $cnt_ejecucion != null ? $cnt_ejecucion = $cnt_ejecucion->cantidad : $cnt_ejecucion = 0;
            $cnt_cierre != null ? $cnt_cierre = $cnt_cierre->cantidad : $cnt_cierre = 0;
            $cnt_fin != null ? $cnt_fin = $cnt_fin->cantidad : $cnt_fin = 0;
            $cnt_suspendido != null ? $cnt_suspendido = $cnt_suspendido->cantidad : $cnt_suspendido = 0;

            $datos[] = [
                'nodo' => $row->first()->nodo,
                'inicio' => $cnt_inicio,
                'ejecucion' => $cnt_ejecucion,
                'cierre' => $cnt_cierre,
                'finalizado' => $cnt_fin,
                'suspendido' => $cnt_suspendido
            ];
        }
        return $datos;
    }

    public function seguimientoDeTecnoparqueFases()
    {
        $datos = array();
        $Pabiertos = 0;
        $Pfinalizados = 0;
        // Proyectos
        $Pabiertos = $this->getProyectoRepository()->proyectosSeguimientoAbiertos()->get();
        $Pfinalizados = $this->getProyectoRepository()->proyectosSeguimientoCerrados(Carbon::now()->isoFormat('YYYY'))->get();

        $abiertosAgrupados = $this->agruparProyectosAbiertos($Pabiertos);
        $cerradosAgrupados = $this->agruparProyectosCerrados($Pfinalizados);
        $datos = $this->retornarValoresDelSeguimientoPorFases($abiertosAgrupados, $cerradosAgrupados);
        return response()->json([
            'datos' => $datos
        ]);
    }

    public function seguimientoProyectosInscritosPorMes(int $id)
    {
        $gestor = User::find($id);
        $idgestor = $gestor->id;
        $idnodo = $gestor->experto->nodo_id;

        $datos = array();
        // Proyectos
        $datos = $this->getProyectoRepository()->proyectosInscritosPorMes(Carbon::now()->isoFormat('YYYY'))->where('users.id', $idgestor)->where('nodos.id', $idnodo)->get();
        $datos = $this->agruparDatosPorMeses($datos);

        return response()->json([
            'datos' => $datos
        ]);
    }


    /**
     * Retorna el valor de los nodos de los que se consultarán el seguimiento
     *
     * @param $request
     * @return array
     * @author dum
     **/
    private function retornarValorDeNodos($request)
    {
        if (Str::contains(session()->get('login_role'), [User::IsActivador(), User::IsAdministrador(), User::IsAuxiliar()])) {
            if ($request->nodos[0] == 'all') {
                $nodos_temp = Nodo::SelectNodo()->get();
                foreach ($nodos_temp as $nodo) {
                    $nodos[] = $nodo->id;
                }
            } else {
                $nodos = $request->nodos;
            }
        } else {
            $nodos = [request()->user()->getNodoUser()];
        }
        return $nodos;
    }


    /**
     * Retorna el valor de los expertos de los que se consultarán el seguimiento
     *
     * @param $request
     * @return array
     * @author dum
     **/
    private function retornarValorDeExpertos($request)
    {
        $expertos_temp = User::ConsultarFuncionarios(request()->user()->getNodoUser(), User::IsExperto())->get();
        if (Str::contains(session()->get('login_role'), [User::IsDinamizador(), User::IsInfocenter(), User::IsArticulador()])) {
            if ($request->expertos[0] == 'all') {
                foreach ($expertos_temp as $experto) {
                    $expertos[] = $experto->id;
                }
            } else {
                $expertos = $request->expertos;
            }
        } else {
            $expertos = [request()->user()->id];
        }
        return $expertos;
    }

    public function seguimientoProyectosInscritos(Request $request)
    {
        $nodos = $this->retornarValorDeNodos($request);
        if (Str::contains(session()->get('login_role'), [User::IsActivador(), User::IsAdministrador(), User::IsAuxiliar()])) {
            $query = $this->getProyectoRepository()->proyectosInscritosPorMes(Carbon::now()->isoFormat('YYYY'))->whereIn('nodos.id', $nodos)->get();
        } else {
            $expertos = $this->retornarValorDeExpertos($request);
            $query = $this->getProyectoRepository()->proyectosInscritosPorMes(Carbon::now()->isoFormat('YYYY'))->whereIn('nodos.id', $nodos)->whereIn('users.id', $expertos)->get();
        }
        // dd($query);

        $datos = $this->agruparDatosPorMeses($query);
        return response()->json([
            'datos' => $datos
        ]);
    }



    public function seguimientoArticulacionesInscritas(Request $request)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $nodos = $this->retornarValorDeNodos($request);

        $query = $this->articulationRepository->articulacionesInscritasPorMes(Carbon::now()->isoFormat('YYYY'))
            ->whereIn('nodos.id', $nodos)->get();

        $datos = $this->agruparDatosPorMeses($query);
        return response()->json([
            'datos' => $datos
        ]);
    }

    public function seguimientoProyectosCerrados(Request $request)
    {
        $nodos = $this->retornarValorDeNodos($request);
        if (Str::contains(session()->get('login_role'), [User::IsActivador(), User::IsAdministrador(), User::IsAuxiliar()])) {
            $query = $this->getProyectoRepository()->proyectosCerradosPorMes(Carbon::now()->isoFormat('YYYY'))->whereIn('nodos.id', $nodos)->get();
        } else {
            $expertos = $this->retornarValorDeExpertos($request);
            $query = $this->getProyectoRepository()->proyectosCerradosPorMes(Carbon::now()->isoFormat('YYYY'))->whereIn('nodos.id', $nodos)->whereIn('users.id', $expertos)->get();
        }

        $datos = $this->agruparDatosPorMeses($query);

        return response()->json([
            'datos' => $datos
        ]);
    }


    public function seguimientoArticulacionesCerradas(Request $request)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $nodos = $this->retornarValorDeNodos($request);
        $query = $this->articulationRepository->articulacionesCerradasPorMes(Carbon::now()->isoFormat('YYYY'))
            ->whereIn('nodos.id', $nodos)->get();
        $datos = $this->agruparDatosPorMeses($query);
        return response()->json([
            'datos' => $datos
        ]);
    }

    public function agruparDatosPorMeses($datos)
    {
        $meses = [];
        $cantidades = [];
        foreach ($datos as $key => $dato) {
            $meses[$key] = $dato->nombre_mes;
            $cantidades[$key] = $dato->cantidad;
        }
        return array('meses' => $meses, 'cantidades' => $cantidades);
    }

    /**
     * Consulta el seguimiento de un experto, por fases actuales
     * @param int $id Id del experto
     * @return Response
     * @author dum
     **/
    public function seguimientoActualDelGestor(int $id)
    {
        $experto = User::find($id);
        $idexperto = $experto->id;
        // dd($experto->experto->nodo_id);
        $idnodo = $experto->experto->nodo_id;

        // $datos = array();
        $Pabiertos = 0;
        $Pfinalizados = 0;
        // Proyectos

        $Pabiertos = $this->getProyectoRepository()->proyectosSeguimientoAbiertos()->select('entidades.nombre', 'fases.nombre as fase')->selectRaw('count(trl_esperado) as trl_esperado')->groupBy('entidades.nombre', 'fase')->where('nodos.id', $idnodo)->where('users.id', $idexperto)->get();
        $Pfinalizados = $this->getProyectoRepository()->proyectosSeguimientoCerrados(Carbon::now()->isoFormat('YYYY'))->where('users.id', $idexperto)->where('nodos.id', $idnodo)->get();
        $agrupados = $this->retornarValoresDelSeguimientoPorFasesNoGroup($Pabiertos, $Pfinalizados);
        // dd($agrupados);
        return response()->json([
            'datos' => $agrupados
        ]);
    }


    /**
     * Retorna un array con los valores del seguimiento por fase actual
     * @param object $abiertos con los totales de proyectos activos
     * @param object $cerrados con los totales de proyectos cerrados
     * @return array
     */
    private function retornarValoresDelSeguimientoPorFasesNoGroup($abiertos, $cerrados)
    {
        $datos = [];
        // $temporal = $abiertos;
        // $fases = Fase::all();
        // foreach ($fases as $fase) {
        $cnt_inicio = $abiertos->where('fase', 'Inicio')->first();
        $cnt_planeacion = $abiertos->where('fase', 'Planeación')->first();
        $cnt_ejecucion = $abiertos->where('fase', 'Ejecución')->first();
        $cnt_cierre = $abiertos->where('fase', 'Cierre')->first();
        $cnt_fin = $cerrados->where('fase', 'Finalizado')->first();
        $cnt_suspendido = $cerrados->where('fase', 'Cancelado')->first();

        $cnt_inicio != null ? $cnt_inicio = $cnt_inicio->trl_esperado : $cnt_inicio = 0;
        $cnt_planeacion != null ? $cnt_planeacion = $cnt_planeacion->trl_esperado : $cnt_planeacion = 0;
        $cnt_ejecucion != null ? $cnt_ejecucion = $cnt_ejecucion->trl_esperado : $cnt_ejecucion = 0;
        $cnt_cierre != null ? $cnt_cierre = $cnt_cierre->trl_esperado : $cnt_cierre = 0;
        $cnt_fin != null ? $cnt_fin = $cnt_fin->cantidad : $cnt_fin = 0;
        $cnt_suspendido != null ? $cnt_suspendido = $cnt_suspendido->cantidad : $cnt_suspendido = 0;

        $datos = [
            // 'nodo' => $row->first()->nombre,
            'Inicio' => (int)$cnt_inicio,
            'Planeacion' => (int)$cnt_planeacion,
            'Ejecucion' => (int)$cnt_ejecucion,
            'Cierre' => (int)$cnt_cierre,
            'Finalizado' => (int)$cnt_fin,
            'Suspendido' => (int)$cnt_suspendido,
            'Total' => $cnt_inicio + $cnt_planeacion + $cnt_ejecucion + $cnt_cierre + $cnt_fin + $cnt_suspendido
        ];
        // }
        return $datos;
    }


    /**
     * Consulta el seguimiento de una línea de un nodo, por fases actuales
     * @param int $idlinea Id de la línea
     * @param int $idnodo Id del nodo
     * @return Response
     * @author dum
     **/
    public function seguimientoActualDeLaLinea($idlinea, $idnodo)
    {
        if (Session::get('login_role') == User::IsDinamizador()) {
            $idnodo = auth()->user()->dinamizador->nodo_id;
        }
        if (Session::get('login_role') == User::IsExperto()) {
            $idnodo = auth()->user()->experto->nodo_id;
        }

        $datos = array();
        $Pabiertos = 0;
        $Pfinalizados = 0;
        // Proyectos
        $Pabiertos = $this->getProyectoRepository()->proyectosSeguimientoAbiertos()->where('lineastecnologicas.id', $idlinea)->where('nodos.id', $idnodo)->get();
        $Pfinalizados = $this->getProyectoRepository()->proyectosSeguimientoCerrados(Carbon::now()->isoFormat('YYYY'))->where('lineastecnologicas.id', $idlinea)->where('nodos.id', $idnodo)->get();

        $abiertosAgrupados = $this->agruparProyectosAbiertos($Pabiertos);
        $cerradosAgrupados = $this->agruparProyectosCerrados($Pfinalizados);

        $datos = $this->retornarValoresDelSeguimientoPorFases($abiertosAgrupados, $cerradosAgrupados);
        return response()->json([
            'datos' => $datos
        ]);
    }



    /**
     * Asigna un valor a $proyectoRepository
     * @param object $proyectoRepository
     * @return void
     * @author dum
     */
    private function setProyectoRepository($proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    /**
     * Retorna el valor de $proyectoRepository
     * @return object
     * @author dum
     */
    private function getProyectoRepository()
    {
        return $this->proyectoRepository;
    }

    /**
     * Asigna un valor a $lineaRepository
     * @param object
     * @return void
     * @author dum
     */
    private function setLineaRepository($lineaRepository)
    {
        $this->lineaRepository = $lineaRepository;
    }

    /**
     * Retorna el valor de $lineaRepository
     * @return object
     * @author dum
     */
    private function getLineaRepository()
    {
        return $this->lineaRepository;
    }
}
