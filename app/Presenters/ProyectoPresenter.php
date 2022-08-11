<?php

namespace App\Presenters;

use App\Models\{Proyecto};

class ProyectoPresenter extends Presenter
{
    protected $proyecto;

    public function __construct(Proyecto $proyecto)
    {
        $this->proyecto = $proyecto;
    }

    public function proyectoTrlEsperado()
    {
        if ($this->proyecto->trl_esperado == Proyecto::IsTrl6Esperado()) {
            return 'TRL 6';
        } else {
            return 'TRL 7 - 8';
        }
    }

    public function proyectoTrlObtenido()
    {
        switch ($this->proyecto->trl_obtenido) {
            case Proyecto::IsTrl6Obtenido():
                return 'TRL 6';
                break;
            case Proyecto::IsTrl7Obtenido():
                return 'TRL 7';
                break;
            case Proyecto::IsTrl8Obtenido():
                return 'TRL 8';
                break;
            default:
                return 'error';
                break;
        }
    }

    public function proyectoRutaActual()
    {
        if ($this->proyecto->fase->nombre == 'Finalizado' || $this->proyecto->fase->nombre == 'Suspendido') {
            return route('proyecto.detalle', $this->proyecto->id);
        } else if ($this->proyecto->fase->nombre == 'Inicio') {
            return route('proyecto.inicio', $this->proyecto->id);
        } else if ($this->proyecto->fase->nombre == 'Planeación') {
            return route('proyecto.planeacion', $this->proyecto->id);
        } else if ($this->proyecto->fase->nombre == 'Ejecución') {
            return route('proyecto.ejecucion', $this->proyecto->id);
        } else {
            return route('proyecto.cierre', $this->proyecto->id);
        }
    }

    public function proyectoFechaCierre()
    {
        if ($this->proyecto->fase->nombre == 'Suspendido' || $this->proyecto->fase->nombre == 'Finalizado') {
            if ($this->proyecto->articulacion_proyecto->actividad->fecha_cierre == null) {
                return "No registra";
            } else {
                return $this->proyecto->articulacion_proyecto->actividad->fecha_cierre->isoFormat('YYYY-MM-DD');
            }
        } else {
            return 'El proyecto no se ha cerrado';
        }
    }

    public function proyectoFechaInicio()
    {
        if ($this->proyecto->articulacion_proyecto->actividad->fecha_inicio == null) {
            return "No registra";
        } else {
            return $this->proyecto->articulacion_proyecto->actividad->fecha_inicio->isoFormat('YYYY-MM-DD');
        }
    }

    public function proyectoFabricaProductividad()
    {
        if ($this->proyecto->fabrica_productividad == 0) {
            return 'No';
        } else {
            return 'Si';
        }
    }

    public function proyectoRecibidoAreaEmprendimiento()
    {
        if ($this->proyecto->reci_ar_emp == 0) {
            return 'No';
        } else {
            return 'Si';
        }
    }

    public function proyectoEconomiaNaranja()
    {
        if ($this->proyecto->economia_naranja == 0) {
            return 'No';
        } else {
            return 'Si';
        }
    }

    public function proyectoTipoEconomiaNaranja()
    {
        if ($this->proyecto->economia_naranja == 0) {
            return 'No aplica';
        } else {
            return $this->proyecto->tipo_economianaranja;
        }
    }

    public function proyectoDirigidoDiscapacitados()
    {
        if ($this->proyecto->dirigido_discapacitados == 0) {
            return 'No';
        } else {
            return 'Si';
        }
    }

    public function proyectoDirigidoTipoDiscapacitados()
    {
        if ($this->proyecto->dirigido_discapacitados == 0) {
            return 'No aplica';
        } else {
            return $this->proyecto->tipo_discapacitados;
        }
    }

    public function proyectoActorCTi()
    {
        if ($this->proyecto->art_cti == 0) {
            return 'No';
        } else {
            return 'Si';
        }
    }

    public function proyectoNombreActorCTi()
    {
        if ($this->proyecto->art_cti == 0) {
            return 'No aplica';
        } else {
            return $this->proyecto->nom_act_cti;
        }
    }

    public function proyectoDirigidoAreaEmprendimiento()
    {
        if ($this->proyecto->diri_ar_emp == 0) {
            return 'No';
        } else {
            return 'Si';
        }
    }

    public function proyectoOtroAreaConocimiento()
    {
        if ($this->proyecto->areaconocimiento->nombre == 'Otro') {
            return $this->proyecto->otro_areaconocimiento;
        } else {
            return 'No aplica';
        }
    }

    public function proyectoNode()
    {
        if ($this->proyecto->has('nodo.entidad') && isset($this->proyecto->nodo->entidad)) {
            return "Tecnoparque Nodo {$this->proyecto->nodo->entidad->nombre}";
        }
        return "No registra";
    }

    public function proyectoUserAsesor()
    {
        if ($this->proyecto->has('asesor.user') && isset($this->proyecto->asesor->user)) {
            return $this->proyecto->asesor->user->present()->userFullName();
        }
        return "No registra";
    }

    public function proyectoLinea()
    {
        if  ($this->proyecto->has('sublinea.linea') && isset($this->proyecto->sublinea->linea)) {
            return $this->proyecto->sublinea->linea->nombre;
        }
        return "No registra";
    }

    public function proyectoSublinea()
    {
        if  ($this->proyecto->has('sublinea') && isset($this->proyecto->sublinea)) {
            return $this->proyecto->sublinea->nombre;
        }
        return "No registra";
    }

    public function proyectoAbreviaturaLinea()
    {
        if  ($this->proyecto->has('sublinea.linea') && isset($this->proyecto->sublinea->linea)) {
            return $this->proyecto->sublinea->linea->abreviatura;
        }
        return "No registra";
    }

    public function proyectoEvidenciaTrl()
    {
        if ($this->proyecto->evidencia_trl == 1)
        {
            return 1;
        }
        return 0;
    }

    public function isProyectoEconomiaNaranja()
    {
        if ($this->proyecto->economia_naranja == 1)
        {
            return 1;
        }
        return 0;
    }

    public function isProyectoDirigidoDiscapacitados()
    {
        if ($this->proyecto->dirigido_discapacitados == 1)
        {
            return 1;
        }
        return 0;
    }

    public function isProyectoActorCTi()
    {
        if ($this->proyecto->art_cti == 1)
        {
            return 1;
        }
        return 0;
    }

    public function proyectoFase()
    {
        if ($this->proyecto->has('fase') && isset($this->proyecto->fase)) {
            return $this->proyecto->fase->nombre;
        }
        return "No registra";
    }

    public function isAprobacionDinamizadorEjecucion()
    {
        if ($this->proyecto->articulacion_proyecto->aprobacion_dinamizador_ejecucion == 1)
        {
            return 1;
        }
        return 0;
    }

    public function isAprobacionDinamizadorSuspender()
    {
        if ($this->proyecto->articulacion_proyecto->aprobacion_dinamizador_suspender == 1)
        {
            return 1;
        }
        return 0;
    }

    public function proyectoAreaConocimiento()
    {
        if ($this->proyecto->has('areaconocimiento') && isset($this->proyecto->areaconocimiento)) {
            return $this->proyecto->areaconocimiento->nombre;
        }
        return "No registra";
    }

    public function isProyectoTrlObtenido()
    {
        if ($this->proyecto->trl_obtenido == 1)
        {
            return 1;
        }
        return 0;
    }

    public function proyectoConclusiones()
    {
        if ($this->proyecto->has('articulacion_proyecto.actividad') && isset($this->proyecto->articulacion_proyecto->actividad)) {
            return $this->proyecto->articulacion_proyecto->actividad->present()->actividadConclusiones();
        }
        return "No registra";
    }

    public function proyectoPrimerObjetivo()
    {
        if ($this->proyecto->has('articulacion_proyecto.actividad') && isset($this->proyecto->articulacion_proyecto->actividad)) {
            return $this->proyecto->articulacion_proyecto->actividad->present()->actividadPrimerObjetivoEspecifico();
        }
        return "No registra";
    }

    public function proyectoSegundoObjetivo()
    {
        if ($this->proyecto->has('articulacion_proyecto.actividad') && isset($this->proyecto->articulacion_proyecto->actividad)) {
            return $this->proyecto->articulacion_proyecto->actividad->present()->actividadSegundoObjetivoEspecifico();
        }
        return "No registra";
    }

    public function proyectoTercerObjetivo()
    {
        if ($this->proyecto->has('articulacion_proyecto.actividad') && isset($this->proyecto->articulacion_proyecto->actividad)) {
            return $this->proyecto->articulacion_proyecto->actividad->present()->actividadTercerObjetivoEspecifico();
        }
        return "No registra";
    }

    public function proyectoCuartoObjetivo()
    {
        if ($this->proyecto->has('articulacion_proyecto.actividad') && isset($this->proyecto->articulacion_proyecto->actividad)) {
            return $this->proyecto->articulacion_proyecto->actividad->present()->actividadCuartoObjetivoEspecifico();
        }
        return "No registra";
    }

    public function proyectoTrlPrototipo()
    {
        if (isset($this->proyecto->trl_prototipo)) {
            return $this->proyecto->trl_prototipo;
        }
        return "No registra";
    }

    public function proyectoEvidenciasPruebasDocumentadas()
    {
        if (isset($this->proyecto->trl_pruebas)) {
            return $this->proyecto->trl_pruebas;
        }
        return "No registra";
    }

    public function proyectoEvidenciasModeloNegocio()
    {
        if (isset($this->proyecto->trl_modelo)) {
            return $this->proyecto->trl_modelo;
        }
        return "No registra";
    }

    public function proyectoEvidenciasNormatividad()
    {
        if (isset($this->proyecto->trl_normatividad)) {
            return $this->proyecto->trl_normatividad;
        }
        return "No registra";
    }

    public function proyectoAlcance()
    {
        if  (isset($this->proyecto)) {
            return $this->proyecto->alcance_proyecto;
        }
        return "No registra";
    }

    public function proyectoObjetivoGeneral()
    {
        if ($this->proyecto->has('articulacion_proyecto.actividad') && isset($this->proyecto->articulacion_proyecto->actividad)) {
            return $this->proyecto->articulacion_proyecto->actividad->present()->actividadObjetivoGeneral();
        }
        return "No registra";
    }

    public function talentoInterlocutor()
    {
        if ($this->proyecto->has('articulacion_proyecto.talentos') && isset($this->proyecto->articulacion_proyecto->talentos)) {
            return $this->proyecto->articulacion_proyecto->talentos()->wherePivot('talento_lider', '=', 1)->first()->user->present()->userFullName();
        }
        return "No registra";
    }

    public function proyectoCode()
    {
        if ($this->proyecto->has('articulacion_proyecto.actividad') && isset($this->proyecto->articulacion_proyecto->actividad)) {
            return $this->proyecto->articulacion_proyecto->actividad->present()->actividadCode();
        }
        return "No registra";
    }

    public function proyectoName()
    {
        if ($this->proyecto->has('articulacion_proyecto.actividad') && isset($this->proyecto->articulacion_proyecto->actividad)) {
            return $this->proyecto->articulacion_proyecto->actividad->present()->actividadName();
        }
        return "No registra";
    }

    public function proyectoNodoCentro()
    {
        if ($this->proyecto->has('nodo.centro.entidad') && isset($this->proyecto->nodo->centro->entidad)) {
            return $this->proyecto->nodo->centro->entidad->nombre;
        }
        return "No registra";
    }


}
