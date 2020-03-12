<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{TipoArticulacion, Articulacion, Nodo, Gestor, Producto, Actividad};
use App\Http\Requests\ArticulacionFaseInicioFormRequest;
use App\Repositories\Repository\{ArticulacionRepository, EmpresaRepository, GrupoInvestigacionRepository, ArticulacionProyectoRepository, UserRepository\GestorRepository};
use App\Helpers\ArrayHelper;
use App\Http\Controllers\CostoController;
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
use App\User;
use Alert;

class ArticulacionController extends Controller
{

  private $articulacionRepository;
  private $empresaRepository;
  private $grupoInvestigacionRepository;
  private $articulacionProyectoRepository;
  private $gestorRepository;
  private $costoController;

  public function __construct(GestorRepository $gestorRepository, ArticulacionRepository $articulacionRepository, EmpresaRepository $empresaRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository, ArticulacionProyectoRepository $articulacionProyectoRepository, CostoController $costoController)
  {
    $this->articulacionRepository = $articulacionRepository;
    $this->empresaRepository = $empresaRepository;
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    $this->articulacionProyectoRepository = $articulacionProyectoRepository;
    $this->gestorRepository = $gestorRepository;
    $this->costoController = $costoController;
    $this->middleware(['auth']);
  }

  /**
   * Elimina una articulación de la base de datos
   *
   * @param int $id Id de la articulación
   * @return Response
   * @author dum
   */
  public function eliminarArticulación(int $id)
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $delete = $this->articulacionRepository->eliminarArticulacion_Repository($id);
      return response()->json([
        'retorno' => $delete
      ]);
    } else {
      abort('403');
    }
  }

  /**
   * Modifica los datos de una articulación en la fase de inicio
   *
   * @param Request $request
   * @param int $id Id de la articulación
   * @return Response
   * @author dum
   **/
  public function updateInicio(Request $request, int $id)
  {
    if (Session::get('login_role') == User::IsGestor()) {
      $req = new ArticulacionFaseInicioFormRequest;
      $validator = Validator::make($request->all(), $req->rules(), $req->messages());
      if ($validator->fails()) {
        return response()->json([
          'state'   => 'error_form',
          'errors' => $validator->errors(),
        ]);
      } else {
        $result = $this->articulacionRepository->update($request, $id);
        if ($result) {
          return response()->json(['state' => 'update']);
        } else {
          return response()->json(['state' => 'no_update']);
        }
      }
    } else {
      $update = $this->articulacionRepository->updateFaseArticulacion($id, 'Planeación');
      if ($update) {
        Alert::success('Aprobación Exitosa!', 'La articulación ha cambiado a fase de planeación!')->showConfirmButton('Ok', '#3085d6');
        return redirect()->route('articulacion.inicio', $id);
      } else {
        Alert::error('Aprobación Errónea!', 'La articulación no se ha cambiado de fase!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    }
  }

    /**
   * Modifica los datos de una articulación en el estado de planeación
   * 
   * @param \Illuminate\Http\Request $request
   * @param int $id Id de la articulación
   * @return \Illuminate\Http\Response
   * @author dum
   */
  public function updatePlaneacion(Request $request, $id)
  {
    if (Session::get('login_role') == User::IsGestor()) {
      $update = $this->articulacionRepository->updateEntregablesPlaneacionArticulacionRepository($request, $id);
      if ($update) {
        Alert::success('Modificación Exitosa!', 'Los entregables de la articulación en la fase de planeación se han modificado!')->showConfirmButton('Ok', '#3085d6');
        return back();
      } else {
        Alert::error('Modificación Errónea!', 'Los entregables de la articulación en la fase de planeación no se han modificado!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    } else {
      $aprobar = $this->articulacionRepository->updateFaseArticulacion($id, 'Ejecución');
      if ($aprobar) {
        Alert::success('Modificación Exitosa!', 'El proyecto ha cambiado a fase de ejecución!')->showConfirmButton('Ok', '#3085d6');
        return back();
      } else {
        Alert::error('Modificación Errónea!', 'El proyecto no ha cambiado a fase de ejecución!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    }
  }

  /**
   * Modifica los cambios de la fase de ejecución
   * @param Request $request
   * @param int $id Id de la articulacion
   * @return Response
   * @author dum
   **/
  public function updateEjecucion(Request $request, $id)
  {
    if (Session::get('login_role') == User::IsGestor()) {
      $update = $this->articulacionRepository->updateEntregablesEjecucionArticulacionRepository($request, $id);
      if ($update) {
        Alert::success('Modificación Exitosa!', 'Los entregables de la articulación en la fase de ejecución se han modificado!')->showConfirmButton('Ok', '#3085d6');
        return back();
      } else {
        Alert::error('Modificación Errónea!', 'Los entregables de la articulación en la fase de ejecución no se han modificado!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    } else {
      $update = $this->articulacionRepository->setPostCierreArticulacionRepository($id);
      if ($update) {
        Alert::success('Modificación Exitosa!', 'La fase de ejecución de la articulación se ha aprobado!')->showConfirmButton('Ok', '#3085d6');
        return back();
      } else {
        Alert::error('Modificación Errónea!', 'La fase de ejecución de la articulación no se ha aprobado!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    }
  }

  /**
   * Cambia los datos de la articulación en estado de cierre
   * 
   * @param Request $request
   * @param int $id Id de la articulación
   * @author dum
   */
  public function updateCierre(Request $request, int $id)
  {
    if (Session::get('login_role') == User::IsGestor()) {
      $articulacion = Articulacion::findOrFail($id);
      if ($articulacion->articulacion_proyecto->actividad->aprobacion_dinamizador == 1) {

        $validator = Validator::make(
          $request->all(),
          [
            'txtfecha_cierre' => 'required|date_format:"Y-m-d"',
          ],
          [
            'txtfecha_cierre.required' => 'La fecha de cierre del proyecto es obligatoria.',
            'txtfecha_cierre.date_format' => 'El formato de la fecha de cierre es incorrecto ("AAAA-MM-DD")'
          ]
        );
        if ($validator->fails()) {
          return response()->json([
            'state'   => 'error_form',
            'errors' => $validator->errors(),
          ]);
        } else {
          $cerrar = $this->getProyectoRepository()->cerrarProyecto($request, $articulacion);
          if ($cerrar) {
            return response()->json(['state' => 'update']);
          } else {
            return response()->json(['state' => 'no_update']);
          }
        }
      } else {
        // $req = new ProyectoFaseCierreFormRequest;
        // $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        // if ($validator->fails()) {
        //   return response()->json([
        //     'state'   => 'error_form',
        //     'errors' => $validator->errors(),
        //   ]);
        // } else {
        //   $result = $this->getProyectoRepository()->updateCierreProyectoRepository($request, $id);
        //   if ($result) {
        //     return response()->json(['state' => 'update']);
        //   } else {
        //     return response()->json(['state' => 'no_update']);
        //   }
        // }
      }
    } else {
      $update = $this->articulacionRepository->updateAprobacionDinamizador($id);
      if ($update) {
        Alert::success('Modificación Exitosa!', 'La fase de cierre se aprobó!')->showConfirmButton('Ok', '#3085d6');
        return back();
      } else {
        Alert::error('Modificación Errónea!', 'La fase de cierre no se aprobó!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    }
  }

  /**
   * Método que valida cuales fueron los productos elegidos (en la fase de inicio)
   *
   * @param Eloquent $productos
   * @return Eloquet $productosElegidos
   * @return array
   * @author dum
   **/
  public function productosElegidos($productos, $productosElegidos)
  {
    for ($i=0; $i < $productos->count() ; $i++) {
      for ($j=0; $j < $productosElegidos->count() ; $j++) {
        if ($productos[$i]->id == $productosElegidos[$j]->id) {
          $productos[$i]['alcanzar'] = 1;
        }
      }
    }
    return $productos;
  }

    /**
   * Vista para el formulario de los entregables de la fase de inicio de una articulación
   *
   * @param int $id Id de la articulacion
   * @return Response
   * @author dum
   */
  public function entregables_inicio($id)
  {
    $articulacion = Articulacion::findOrFail($id);
    if (Session::get('login_role') == User::IsGestor()) {
      return view('articulaciones.gestor.entregables_inicio', [
        'articulacion' => $articulacion
      ]);
    }
  }

  /**
   * Vista para subir las entregables de una articulacion en la fase de cierre
   * 
   * @param int $id Id de la articulación
   * @return Response
   * @author dum
   */
  public function entregables_cierre(int $id)
  {
    $articulacion = Articulacion::findOrFail($id);
    if (Session::get('login_role') == User::IsGestor()) {
      return view('articulaciones.gestor.entregables_cierre', [
        'articulacion' => $articulacion
      ]);
    }
  }



  /**
   * Fase de inicio de la articulación
   * 
   * @param int $id Id de la articulación
   * @return Response
   * @author dum
   */
  public function inicio(int $id)
  {
    $articulacion = Articulacion::findOrFail($id);
    $productos = Producto::orderBy('nombre')->get();
    $historico = Actividad::consultarHistoricoActividad($articulacion->articulacion_proyecto->actividad->id)->get();
    // dd($historico);

    $productos = $this->productosElegidos($productos, $articulacion->productos);

    switch (Session::get('login_role')) {
      case User::IsGestor():
        return view('articulaciones.gestor.fase_inicio', [
          'productos' => $productos,
          'articulacion' => $articulacion,
          'historico' => $historico
        ]);
      break;
      
      case User::IsDinamizador():
        return view('articulaciones.dinamizador.fase_inicio', [
          'productos' => $productos,
          'articulacion' => $articulacion,
          'historico' => $historico
        ]);
        break;
      
      default:
        # code...
        break;
    }
  }

  /**
   * Vista para subir los entregables de la fase de planeación
   *
   * @param int $id Id de la articulación
   * @return Response
   * @author dum
   **/
  public function planeacion(int $id)
  {
    $articulacion = Articulacion::findOrFail($id);
    $historico = Actividad::consultarHistoricoActividad($articulacion->articulacion_proyecto->actividad->id)->get();
    if ($articulacion->fase->nombre == 'Inicio') {
      Alert::error('Error!', 'La articulación se encuentra en la fase de ' . $articulacion->fase->nombre . '!')->showConfirmButton('Ok', '#3085d6');
      return back();
    } else {
      if (Session::get('login_role') == User::IsGestor()) {
        return view('articulaciones.gestor.fase_planeacion', [
          'articulacion' => $articulacion,
          'historico' => $historico
        ]);
      } else if (Session::get('login_role') == User::IsDinamizador()) {
        return view('articulaciones.dinamizador.fase_planeacion', [
          'articulacion' => $articulacion,
          'historico' => $historico
        ]);
      } else if (Session::get('login_role') == User::IsAdministrador()) {
        // return view('proyectos.administrador.fase_planeacion', [
        //   'proyecto' => $articulacion,
        //   'historico' => $historico
        // ]);
      } else {
        abort('403');
      }
    }
  }

    /**
   * Vista para el formulario de la fase de ejecución del proyecto
   * @param int $id Id del proyecto
   * @return Response
   * @author dum
   */
  public function ejecucion(int $id)
  {
    $articulacion = Articulacion::findOrFail($id);
    $historico = Actividad::consultarHistoricoActividad($articulacion->articulacion_proyecto->actividad->id)->get();
    if ($articulacion->fase->nombre == 'Inicio' || $articulacion->fase->nombre == 'Planeación') {
      Alert::error('Error!', 'La articulación se encuentra en la fase de ' . $articulacion->fase->nombre . '!')->showConfirmButton('Ok', '#3085d6');
      return back();
    } else {
      switch (Session::get('login_role')) {
        case User::IsGestor():
          return view('articulaciones.gestor.fase_ejecucion', [
            'articulacion' => $articulacion,
            'historico' => $historico
          ]);
          break;

        case User::IsDinamizador():
          return view('articulaciones.dinamizador.fase_ejecucion', [
            'articulacion' => $articulacion,
            'historico' => $historico
          ]);
          break;

        case User::IsAdministrador():
          // return view('articulaciones.administrador.fase_ejecucion', [
          //   'articulacion' => $articulacion,
          //   'historico' => $historico
          // ]);
          break;

        default:
          abort('403');
          break;
      }
    }
  }

    /**
   * Vista para el formulario de la fase de cierre
   * @param int $id Id del proyecto
   * @return Response
   * @author dum
   */
  public function cierre(int $id)
  {
    $articulacion = Articulacion::findOrFail($id);
    $historico = Actividad::consultarHistoricoActividad($articulacion->articulacion_proyecto->actividad->id)->get();
    if ($articulacion->articulacion_proyecto->aprobacion_dinamizador_ejecucion == 1) {
      $costo = $this->costoController->costosDeUnaActividad($articulacion->articulacion_proyecto->actividad->id);
      switch (Session::get('login_role')) {
        case User::IsGestor():
          return view('articulaciones.gestor.fase_cierre', [
            'articulacion' => $articulacion,
            'costo' => $costo,
            'historico' => $historico
          ]);
          break;

        case User::IsDinamizador():
          return view('articulaciones.dinamizador.fase_cierre', [
            'articulacion' => $articulacion,
            'costo' => $costo,
            'historico' => $historico
          ]);
          break;

        case User::IsAdministrador():
          // return view('articulaciones.administrador.fase_cierre', [
          //   'proyecto' => $articulacion,
          //   'costo' => $costo,
          //   'historico' => $historico
          // ]);
          break;

        default:
          # code...
          break;
      }
    } else {
      Alert::error('Error!', 'El dinamizador aún no ha dado su aprobación en la fase de ejecución!')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
  }

  /**
   * Función para mostrar las datatables de las articulaciones
   * @param Collection $query Consulta
   * @return Reponse
   */
  private function datatablesArticulaciones($request, $query)
  {
    return datatables()->of($query)
    ->filter(function ($instance) use ($request) {
      if (!empty($request->get('codigo_articulacion'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['codigo_articulacion'], $request->get('codigo_articulacion')) ? true : false;
        });
      }
      if (!empty($request->get('nombre'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['nombre'], $request->get('nombre')) ? true : false;
        });
      }
      if (!empty($request->get('nombre_completo_gestor'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['nombre_completo_gestor'], $request->get('nombre_completo_gestor')) ? true : false;
        });
      }
      if (!empty($request->get('nombre_fase'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['nombre_fase'], $request->get('estado')) ? true : false;
        });
      }
      if (!empty($request->get('search'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          if (Str::contains(Str::lower($row['codigo_articulacion']), Str::lower($request->get('search')))){
            return true;
          }else if (Str::contains(Str::lower($row['nombre']), Str::lower($request->get('search')))) {
            return true;
          }else if (Str::contains(Str::lower($row['nombre_completo_gestor']), Str::lower($request->get('search')))) {
            return true;
          }else if (Str::contains(Str::lower($row['nombre_fase']), Str::lower($request->get('search')))) {
            return true;
          }

          return false;
        });
      }
    })
    ->addColumn('proceso', function ($data) {
      if ($data->nombre_fase == 'Cierre' || $data->nombre_fase == 'Suspendido') {
        $edit = '<a class="btn m-b-xs" href=' . route('articulacion.detalle', $data->id) . '><i class="material-icons">search</i></a>';
      } else {
        $edit = '<a class="btn m-b-xs" href=' . route('articulacion.inicio', $data->id) . '><i class="material-icons">search</i></a>';
      }
      return $edit;
    })->rawColumns(['proceso'])->make(true);
  }

  /**
  * Consulta el detalle de la entidad asociada a la articulación
  * @param int $id id de la articulación
  * @return dum
  * @author dum
  */
  public function consultarEntidadDeLaArticulacion($id)
  {
    $articulacionObj = Articulacion::findOrFail($id);
    $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last()->toArray();
    $entidad = null;
    if ($articulacionObj->tipo_articulacion == Articulacion::IsEmpresa()) {
      $entidad = $this->empresaRepository->consultarDetallesDeUnaEmpresa($articulacionObj->articulacion_proyecto->entidad->empresa->id)->toArray();
      $entidad = ArrayHelper::validarDatoNullDeUnArray($entidad);
    } else if ($articulacionObj->tipo_articulacion == Articulacion::IsGrupo()) {
      $entidad = $this->grupoInvestigacionRepository->consultarDetalleDeUnGrupoDeInvestigacion($articulacionObj->articulacion_proyecto->entidad->grupoinvestigacion->id)->toArray();
      $entidad = ArrayHelper::validarDatoNullDeUnArray($entidad);
    } else {
      $entidad = $this->articulacionProyectoRepository->consultarTalentosDeUnaArticulacionProyectoRepository($articulacionObj->articulacion_proyecto->id)->toArray();
    }
    return response()->json([
      'detalles' => $entidad,
      'articulacion' => $articulacion
    ]);
  }

  // Consulta los detalles de los entregables de una articulacion (Solo los checkboxes)
  public function detallesDeLosEntregablesDeUnaArticulacion($id)
  {
    $entregables = $this->articulacionRepository->consultaEntregablesDeUnaArticulacion($id)->last()->toArray();
    $entregables = ArrayHelper::validarEntregablesNullDeUnArrayString($entregables);
    $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last()->toArray();
    return response()->json([
      'entregables' => $entregables,
      'articulacion' => $articulacion,
    ]);
  }

  /**
  * Consulta los datos de una articulación por su id
  * @param int $id Id de la articulación
  * @return Response
  * @author dum
  */
  public function detallesDeUnArticulacion($id)
  {
    $detalles = $this->articulacionRepository->consultarArticulacionPorId($id)->last()->toArray();
    $detalles = ArrayHelper::validarDatoNullDeUnArray($detalles);
    return response()->json([
      'detalles' => $detalles,
    ]);
  }

    /**
   * Notifica al dinamizador para que apruebe la articulación en la fase de inicio
   * 
   * @param int $id Id del articulacion
   * @return Response
   * @author dum
   */
  public function notificar_inicio(int $id)
  {
    $notificacion = $this->articulacionRepository->notificarAlDinamziador_Inicio($id);
    if ($notificacion) {
      Alert::success('Notificación Exitosa!', 'Se le ha enviado una notificación al dinamizador para que apruebe la fase de inicio de la articulación!')->showConfirmButton('Ok', '#3085d6');
    } else {
      Alert::error('Notificación Errónea!', 'No se le ha enviado una notificación al dinamizador para que apruebe la fase de inicio de la articulación!')->showConfirmButton('Ok', '#3085d6');
    }
    return back();
  }

    /**
   * Notifica al dinamizador para que apruebe la articulación en la fase de planeacion
   * 
   * @param int $id Id del articulacion
   * @return Response
   * @author dum
   */
  public function notificar_planeacion(int $id)
  {
    $notificacion = $this->articulacionRepository->notificarAlDinamizador_Planeacion($id);
    if ($notificacion) {
      Alert::success('Notificación Exitosa!', 'Se le ha enviado una notificación al dinamizador para que apruebe la fase de planeación de la articulación!')->showConfirmButton('Ok', '#3085d6');
    } else {
      Alert::error('Notificación Errónea!', 'No se le ha enviado una notificación al dinamizador para que apruebe la fase de planeación de la articulación!')->showConfirmButton('Ok', '#3085d6');
    }
    return back();
  }

    /**
   * Notitica al dinamizador para que apruebe la fase de ejecución
   *
   * @param int $id Id de la articulación
   * @return Response
   * @author dum
   **/
  public function notificar_ejecucion(int $id)
  {
    $notificacion = $this->articulacionRepository->notificarAlDinamizador_Ejecucion($id);
    if ($notificacion) {
      Alert::success('Notificación Exitosa!', 'Se le ha enviado una notificación al dinamizador para que apruebe la fase de ejecución de la articulación!')->showConfirmButton('Ok', '#3085d6');
    } else {
      Alert::error('Notificación Errónea!', 'No se le ha enviado una notificación al dinamizador para que apruebe la fase de ejecución de la articulación!')->showConfirmButton('Ok', '#3085d6');
    }
    return back();
  }

  /**
   * Notifica al dinamizador para que apruebe la articulación en la fase de cierre
   * 
   * @param int $id Id de la articulación
   * @return Response
   * @author dum
   */
  public function notificar_cierre(int $id)
  {
    $notificacion = $this->articulacionRepository->notificarAlDinamziador_Cierre($id);
    if ($notificacion) {
      Alert::success('Notificación Exitosa!', 'Se le ha enviado una notificación al dinamizador para que apruebe la fase de cierre de la articulación!')->showConfirmButton('Ok', '#3085d6');
    } else {
      Alert::error('Notificación Errónea!', 'No se le ha enviado una notificación al dinamizador para que apruebe la fase de cierre de la articulación!')->showConfirmButton('Ok', '#3085d6');
    }
    return back();
  }

  /**
   * modifica los entregables de una articulación
   *
   * @param Request $request
   * @param int $id Id de la articulacion
   * @return Response
   * @author Victor Manuel Moreno Vega
   */
  public function updateEntregables(Request $request, $id)
  {
    if (Session::get('login_role') == User::IsGestor()) {
      $update = $this->articulacionRepository->updateEntregablesInicioArticulacionRepository($request, $id);
      if ($update) {
        Alert::success('Modificación Exitosa!', 'Los entregables de la articulación se han modificado!')->showConfirmButton('Ok', '#3085d6');
        return redirect()->route('articulacion.inicio', $id);
      } else {
        Alert::error('Modificación Errónea!', 'Los entregables de la articulación no se han modificado!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    }
  }


  public function updateEntregables_Cierre(Request $request, $id)
  {
    $articulacion = Articulacion::findOrFail($id);
    if ($articulacion->articulacion_proyecto->aprobacion_dinamizador_ejecucion == 1) {
      if (Session::get('login_role') == User::IsGestor()) {
        $update = $this->articulacionRepository->updateEntregableCierreArticulacionRepository($request, $id);
        if ($update) {
          Alert::success('Modificación Exitosa!', 'Los entregables de la articulación en la fase de cierre se han modificado!')->showConfirmButton('Ok', '#3085d6');
          return back();
        } else {
          Alert::error('Modificación Errónea!', 'Los entregables de la articulación en la fase de cierre no se han modificado!')->showConfirmButton('Ok', '#3085d6');
          return back();
        }
      }
    } else {
      Alert::error('Error!', 'El dinamizador aún no ha aprobado la fase de ejecución de la articulación!')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
  }

  /**
   * Vista para subir y ver los entregables de una articulación*
   * @param int $id Id de la articulacion
   * @return Response
   * @author Victor Manuel Moreno Vega
   */
  public function entregables($id)
  {
    $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
    $view = "";
    if ( \Session::get('login_role') == User::IsGestor() ) {
      $view = 'articulaciones.gestor.entregables';
    } else if ( \Session::get('login_role') == User::IsDinamizador() ) {
      $view = 'articulaciones.dinamizador.entregables';
    } else {
      $view = 'articulaciones.administrador.entregables';
    }
    return view($view, [
      'articulacion' => $articulacion
    ]);

  }

  // Datatable para mostrar las articulaciones POR NODO
  public function datatableArticulacionesPorNodo(Request $request, $id, $anho)
  {
    if (request()->ajax()) {
      if (\Session::get('login_role') == User::IsDinamizador()) {
        $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnNodo(auth()->user()->dinamizador->nodo_id, $anho)->get();
      } else {
        $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnNodo($id, $anho)->get();
      }
      
      return $this->datatablesArticulaciones($request, $articulaciones);
    }
  }

  /**
  * Consulta las articulaciones de un gestor
  * @param Request $request
  * @param int $id Id del gestor
  * @param string $anho Año de inicio de las articulaciones
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function datatableArticulacionesPorGestor(Request $request, $id, $anho)
  {
    if (request()->ajax()) {
      $idgestor = $id;
      if ( Session::get('login_role') == User::IsGestor() ) {
        $idgestor = auth()->user()->gestor->id;
      }

      $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnGestor($anho)->where('actividades.gestor_id', $idgestor)->get();
      return $this->datatablesArticulaciones($request, $articulaciones);
    }
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    switch (\Session::get('login_role')) {
      case User::IsAdministrador():
        return view('articulaciones.administrador.index', [
          'nodos' => Nodo::SelectNodo()->get(),
        ]);
        break;
      case User::IsDinamizador():
        return view('articulaciones.dinamizador.index', [
          'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
        ]);
        break;
      case User::IsGestor():
        return view('articulaciones.gestor.index');
        break;

      default:
        return back();
        break;
    }
  }


  // Consulta los tipos de articulaciones que se pueden realizar con grupos de investigación, empresas ó emprendedores
  public function consultarTipoArticulacion($tipo)
  {
    $tiposarticulacion = "";
    if ($tipo == 0) {
      $tiposarticulacion = TipoArticulacion::ConsultarTipoArticulacionConGruposDeInvestigacion()->get();
    } else {
      $tiposarticulacion = TipoArticulacion::ConsultarTipoArticulacionConEmpresasEmprendedores()->get();
    }
    return response()->json([
      'tiposarticulacion' => $tiposarticulacion,
    ]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    if (\Session::get('login_role') == User::IsGestor()) {
      return view('articulaciones.gestor.create', [
        'productos' => Producto::orderBy('nombre')->get()
      ]);
    }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    // dd('exit');
    $req = new ArticulacionFaseInicioFormRequest;

    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'state'   => 'error_form',
        'errors' => $validator->errors(),
      ]);
    } else {
      $result = $this->articulacionRepository->create($request);
      if ($result) {
        return response()->json(['state' => 'registro']);
      } else {
        return response()->json(['state' => 'no_registro']);
      }
    }

  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function edit($id)
  {
    $articulacion = Articulacion::find($id);
  
    if ($articulacion->estado == Articulacion::IsCierre()) {
      alert()->warning('Advertencia!','No se puede realizar esta acción por el estado de la articulación es Cierre.')->showConfirmButton('Ok', '#3085d6');
      return back();
    } else {
      $pivot = array();
      if (Articulacion::find($id)->tipo_articulacion == Articulacion::IsEmprendedor()) {
        $pivot = $articulacion->emprendedores;
      }
      // dd($pivot);
      if (\Session::get('login_role') == User::IsGestor()) {
        return view('articulaciones.gestor.edit', [
          'articulacion' => $articulacion,
          'pivot' => $pivot,
        ]);
      } else {
        // dd($articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->id);
        $gestores = $this->gestorRepository->consultarGestoresPorLineaTecnologicaYNodoRepository($articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->id, auth()->user()->dinamizador->nodo_id)->pluck('gestor', 'id');
        return view('articulaciones.dinamizador.edit', [
          'articulacion' => $articulacion,
          'gestores' => $gestores
        ]);
      }

    }
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function update(Request $request, $id)
  {
    if ( Session::get('login_role') == User::IsGestor() ) {
      $req = new ArticulacionFaseInicioFormRequest;
      $validator = \Validator::make($request->all(), $req->rules(), $req->messages());
      if ($validator->fails()) {
        return response()->json([
          'fail' => true,
          'errors' => $validator->errors(),
        ]);
      }
      $result = $this->articulacionRepository->update($request, $id);
      // exit;
      if ($result == false) {
        return response()->json([
          'fail' => false,
          'redirect_url' => false
        ]);
      } else {
        return response()->json([
          'fail' => false,
          'redirect_url' => url(route('articulacion'))
        ]);
      }
    } else {
      $validator = Validator::make($request->all(), [
        'txtgestor_id' => 'required'
      ], ['txtgestor_id.required' => 'El Gestor es obligatorio.']);
      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }
      $update = $this->articulacionRepository->updateGestorArticulacion_Repository($request, $id);
      if ($update) {
        Alert::success('Modificación Exitosa!', 'El gestor de la articulación se ha cambiado!')->showConfirmButton('Ok', '#3085d6');
        return redirect('articulacion');
      } else {
        Alert::error('Modificación Errónea!', 'El gestor de la articulación no se ha cambiado!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    }
  }


  /*===========================================================================
  =            metodo para consultar las articulaciones por gestor            =
  ===========================================================================*/

  public function ArticulacionForGestor($id, int $tipoArticulacion = 0)
  {
      $articulaciones = Articulacion::articulacionesForEstado($tipoArticulacion)->EstadoOfArticulaciones([
        Articulacion::IsInicio(),
        Articulacion::IsEjecucion(),
        Articulacion::IsCierre()
      ])->get();

      return response()->json([
      'articulaciones' => $articulaciones,
      ]);
  }

  /*=====  End of metodo para consultar las articulaciones por gestor  ======*/





}
