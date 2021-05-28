<?php

namespace App\Presenters;

use App\Models\ArticulacionPbt;

class ArticulacionPbtPresenter extends Presenter
{
    protected $articulacionpbt;

    public function __construct(ArticulacionPbt $articulacionpbt)
    {
        $this->articulacionpbt = $articulacionpbt;
    }

    public function articulacionPbtNameFase(){
        if ($this->articulacionpbt->has('fase') && isset($this->articulacionpbt->fase)) {
            return $this->articulacionpbt->fase->nombre;
        }
        return "No registra";
    }


    public function articulacionPbtIssetFase($fase):bool
    {
        if ($this->articulacionpbt->has('fase') && isset($this->articulacionpbt->fase) &&  $this->articulacionpbt->fase->id == $fase) {
            return true;
        }
        return false;
    }

    public function articulacionPbtNameProyecto()
    {
        if ($this->articulacionpbt->has('proyecto') && isset($this->articulacionpbt->proyecto)) {
            return $this->articulacionpbt->proyecto->articulacion_proyecto->actividad->nombre;
        }
        return "No registra";
    }

    public function articulacionPbtCodeProyecto()
    {
        if ($this->articulacionpbt->has('proyecto') && isset($this->articulacionpbt->proyecto)) {
            return $this->articulacionpbt->proyecto->articulacion_proyecto->actividad->codigo_actividad;
        }
        return "No registra";
    }

    public function articulacionPbtClosingDateProyecto()
    {
        if ($this->articulacionpbt->has('proyecto') && isset($this->articulacionpbt->proyecto->articulacion_proyecto->actividad->fecha_cierre)) {
            return $this->articulacionpbt->proyecto->articulacion_proyecto->actividad->fecha_cierre->isoFormat('YYYY-MM-DD');
        }
        return "No registra";
    }

    public function articulacionPbtObjetivoProyecto()
    {
        if ($this->articulacionpbt->has('proyecto') && isset($this->articulacionpbt->proyecto)) {
            return $this->articulacionpbt->proyecto->articulacion_proyecto->actividad->objetivo_general;
        }
        return "No registra";
    }

    public function articulacionPbtIdProyecto()
    {
        if ($this->articulacionpbt->has('proyecto') && isset($this->articulacionpbt->proyecto)) {
            return $this->articulacionpbt->proyecto->id;
        }
        return "No registra";
    }

    public function articulacionPbtNameIdeaProyecto()
    {
        if ($this->articulacionpbt->has('proyecto.idea') && isset($this->articulacionpbt->proyecto->idea)) {
            return $this->articulacionpbt->proyecto->idea->nombre_proyecto;
        }
        return "No registra";
    }

    public function articulacionPbtCodeIdeaProyecto()
    {
        if ($this->articulacionpbt->has('proyecto.idea') && isset($this->articulacionpbt->proyecto->idea)) {
            return $this->articulacionpbt->proyecto->idea->codigo_idea;
        }
        return "No registra";
    }

    public function articulacionPbtIdIdeaProyecto()
    {
        if ($this->articulacionpbt->has('proyecto.idea') && isset($this->articulacionpbt->proyecto->idea)) {
            return $this->articulacionpbt->proyecto->idea->id;
        }
        return "No registra";
    }

    public function articulacionPbtName()
    {
        if ($this->articulacionpbt->has('actividad') && isset($this->articulacionpbt->actividad)) {
            return $this->articulacionpbt->actividad->nombre;
        }
        return "No registra";
    }

    public function articulacionPbtObjetivo()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt)) {
            return $this->articulacionpbt->objetivo;
        }
        return "No registra";
    }

    public function articulacionPbtFechaFinalizacion()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt)) {
            return $this->articulacionpbt->fecha_esperada_finalizacion->isoFormat('YYYY-MM-DD');
        }
        return "No registra";
    }

    public function articulacionPbtNombreConvocatoria()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt)) {
            return $this->articulacionpbt->nombre_convocatoria;
        }
         return "No registra";
    }

    public function articulacionPbtEmail()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt)) {
            return $this->articulacionpbt->email_entidad;
        }
         return "No registra";
    }

    public function articulacionPbtNombreContacto()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt)) {
            return $this->articulacionpbt->nombre_contacto;
        }
         return "No registra";
    }

    public function articulacionPbtEntidad()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt)) {
            return $this->articulacionpbt->entidad;
        }
         return "No registra";
    }

    public function articulacionPbtNombreTipoArticulacion()
    {
        if ($this->articulacionpbt->tipoarticulacion && isset($this->articulacionpbt->tipoarticulacion)) {
            return $this->articulacionpbt->tipoarticulacion->nombre;
        }
         return "No registra";
    }
    
    public function articulacionPbtNombreAlcanceArticulacion()
    {
        if ($this->articulacionpbt->alcancearticulacion && isset($this->articulacionpbt->alcancearticulacion)) {
            return $this->articulacionpbt->alcancearticulacion->nombre;
        }
         return "No registra";
    }

    public function fullNameTalentInterlocutor(){
        if($this->articulacionpbt->talentos != null){
             $talent = $this->articulacionpbt->talentos()->wherePivot('talento_lider', 1)->first();
            return "{$talent->user->documento} - {$talent->user->nombres} {$talent->user->apellidos}";
        }
        return "No registra";
    }

    public function fullNameTalent(){
        if($this->articulacionpbt != null){
            return $this->articulacionpbt->talentos->map(function($val){
                return $val->user->present()->userFullName();
            });
            
        }
        return "No registra";
    }

    
    public function articulacionPbtLeccionesAprendidas()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt)) {
            return $this->articulacionpbt->lecciones_aprendidas;
        }
         return "No registra";
    }

    public function articulacionPbtAprobacionDinamizadorEjecucion()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->aprobacion_dinamizador_ejecucion == 1) {
            return 1;
        }
         return 0;
    }

    public function articulacionPbtAprobacionDinamizadorSuspender()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->aprobacion_dinamizador_suspender == 1) {
            return 1;
        }
         return 0;
    }

    public function articulacionPbtPostulacion()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->postulacion == 1) {
            return 1;
        }
         return 0;
    }

    public function articulacionPbtAprobacion()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->aprobacion == 1) {
            return 1;
        }
         return 0;
    }


    public function articulacionPbtJustificacion()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt)) {
            return $this->articulacionpbt->justificacion;
        }
         return "No registra";
    }

    public function articulacionPbtInformeJustificado()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->informe_justificado == 1) {
            return 1;
        }
         return 0;
    }

    public function articulacionPbtInformeNoAprobado()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->informe_noaprobado == 1) {
            return 1;
        }
         return 0;
    }

    
    public function articulacionPbtRecibira()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt)) {
            return $this->articulacionpbt->recibira;
        }
         return "No registra";
    }

    public function articulacionPbtFechaCuando()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt->cuando)) {
            return $this->articulacionpbt->cuando->isoFormat('YYYY-MM-DD');
        }
        return;
    }

    public function articulacionPbtPdfAprobacion()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->pdf_aprobacion == 1) {
            return 1;
        }
         return 0;
    }

    public function articulacionPbtNoPdfAprobacion()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->pdf_noaprobacion == 1) {
            return 1;
        }
         return 0;
    }

    public function articulacionPbtDocumentoPostualcion()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->documento_postulacion == 1) {
            return 1;
        }
         return 0;
    }

    public function articulacionPbtDocumentoConvocatoria()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->documento_convocatoria == 1) {
            return 1;
        }
         return 0;
    }
    
}