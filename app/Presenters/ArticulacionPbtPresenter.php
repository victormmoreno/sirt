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

    public function articulacionCode()
    {
        if (isset($this->articulacionpbt->codigo)) {
            return $this->articulacionpbt->codigo;
        }
        return "No registra";
    }

    public function articulacionName()
    {
        if (isset($this->articulacionpbt->nombre)) {
            return $this->articulacionpbt->nombre;
        }
        return "No registra";
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
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->articulacionpbt->articulable->articulacion_proyecto->actividad)
        ){
            return $this->articulacionpbt->articulable->articulacion_proyecto->actividad->present()->actividadName();
        }


        return "No registra";
    }

    public function articulacionPbtCodeProyecto()
    {
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->articulacionpbt->articulable->articulacion_proyecto->actividad)
        ){
            return $this->articulacionpbt->articulable->articulacion_proyecto->actividad->present()->actividadCode();
        }
        return "No registra";
    }

    public function articulacionPbtClosingDateProyecto()
    {
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->articulacionpbt->articulable->articulacion_proyecto->actividad)
        ){
            return optional($this->articulacionpbt->articulable->articulacion_proyecto->actividad->fecha_cierre)->isoFormat('YYYY-MM-DD');
        }
        return "No registra";
    }

    public function articulacionPbtObjetivoProyecto()
    {
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->articulacionpbt->articulable->articulacion_proyecto->actividad)
        ){
            return $this->articulacionpbt->articulable->articulacion_proyecto->actividad->objetivo_general;
        }
        return "No registra";
    }

    public function articulacionPbtIdProyecto()
    {
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->articulacionpbt->articulable)
        ){
            return $this->articulacionpbt->articulable->id;
        }
        return "No registra";
    }

    public function articulacionPbtNameIdeaProyecto()
    {
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->articulacionpbt->articulable->idea)
        ){
            return $this->articulacionpbt->articulable->idea->nombre_proyecto;
        }
        return "No registra";
    }

    public function articulacionPbtCodeIdeaProyecto()
    {
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->articulacionpbt->articulable->idea)
        ){
            return $this->articulacionpbt->articulable->idea->codigo_idea;
        }
        return "No registra";
    }

    public function articulacionPbtIdIdeaProyecto()
    {
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->articulacionpbt->articulable->idea)
        ){
            return $this->articulacionpbt->articulable->idea->id;
        }
        return "No registra";
    }


    public function articulacionPbtNameTipoVinculacion()
    {
        if($this->articulacionpbt->tipo_vinculacion == ArticulacionPbt::IsPbt()){
            return "PBT";
        }
        if($this->articulacionpbt->tipo_vinculacion == ArticulacionPbt::IsSenaInnova()){
            return "SENA Innova";
        }
        if($this->articulacionpbt->tipo_vinculacion == ArticulacionPbt::IsColinnova()){
            return "Colinnova";
        }
        return "No registra";
    }

    public function articulacionPbtTipoVinculacion($value):bool
    {
        if($this->articulacionpbt->tipo_vinculacion == $value){
            return true;
        }
        return false;
    }

    public function articulacionPbtSedeEmpresa()
    {
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Sede::class]
            ) && isset($this->articulacionpbt->articulable)
        ){
            return $this->articulacionpbt->articulable->nombre_sede;
        }
        return "No registra";
    }

    public function articulacionPbtSedeEmpresaId()
    {
        if(
            $this->articulacionpbt->whereHasMorph(
                'articulable',
                [ \App\Models\Sede::class]
            ) && isset($this->articulacionpbt->articulable)
        ){
            return $this->articulacionpbt->articulable->id;
        }
        return;
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
            return optional($this->articulacionpbt->fecha_esperada_finalizacion)->isoFormat('YYYY-MM-DD');
        }
        return "No registra";
    }

    public function articulacionPbtNombreConvocatoria()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt->nombre_convocatoria)) {
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

    public function articulacionPbtInforme()
    {
        if ($this->articulacionpbt && isset($this->articulacionpbt) && $this->articulacionpbt->informe != null) {
            return $this->articulacionpbt->informe;
        }
        return 'No registra';
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
            return optional($this->articulacionpbt->cuando)->isoFormat('YYYY-MM-DD');
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
        if (isset($this->articulacionpbt) && $this->articulacionpbt->pdf_noaprobacion == 1) {
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

    public function articulacionPbtName()
    {
        if (isset($this->articulacionpbt)) {
            return $this->articulacionpbt->nombre;
        }
        return "No registra";
    }

    public function articulacionPbtCode()
    {
        if (isset($this->articulacionpbt)) {
            return $this->articulacionpbt->codigo;
        }
        return "No registra";
    }

    public function articulacionPbtstartDate(){
        if (isset($this->articulacionpbt)) {
            return optional($this->articulacionpbt->fecha_inicio)->isoFormat('YYYY-MM-DD');
        }
        return "No registra";
    }

    public function articulacionPbtEndDate(){
        if (isset($this->articulacionpbt)) {
            return optional($this->articulacionpbt->fecha_cierre)->isoFormat('YYYY-MM-DD');
        }
        return "No registra";
    }

    public function articulacionPbtUserAsesor(){
        if (isset($this->articulacionpbt)) {
            return $this->articulacionpbt->asesor->present()->userFullName();
        }
        return "No registra";
    }

    public function articulacionPbtUserRolesAsesor()
    {
        if ($this->articulacionpbt->has('asesor') && isset($this->articulacionpbt->asesor)) {
            return $this->articulacionpbt->asesor->present()->userRolesNames();
        }
        return "No registra";
    }

    public function articulacionPbtNodo()
    {
        if ($this->articulacionpbt->has('nodo.entidad') && isset($this->articulacionpbt->nodo->entidad)) {
            return "Tecnoparque Nodo {$this->articulacionpbt->nodo->entidad->nombre}";
        }
        return "No registra";
    }

    public function articulacionPbtcreatedAt()
    {
        if (isset($this->articulacionpbt)) {
            return optional($this->articulacionpbt->created_at)->isoFormat('LL');
        }
        return "No registra";
    }
}
