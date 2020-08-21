<?php

namespace App\Presenters;

use App\Models\UsoInfraestructura;

class UsoInfraestructuraPresenter extends Presenter
{
    protected $uso;

    public function __construct(UsoInfraestructura $uso)
    {
        $this->uso = $uso;
    }

    public function tipoUsoInfraestructura()
    {
        return $this->uso->tipo_usoinfraestructura == UsoInfraestructura::IsProyecto() ? 'Proyecto' : $this->uso->tipo_usoinfraestructura == UsoInfraestructura::IsArticulacion() ? 'Articulación' : $this->uso->tipo_usoinfraestructura == UsoInfraestructura::IsEst() ? 'EDT' : 'No Registra';
    }

    public function fechaUsoInfraestructura()
    {
        return optional($this->uso->fecha)->isoFormat('DD/MM/YYYY');
    }

    public function descripcion()
    {
        return "{$this->uso->descripcion}";
    }

    public function estado()
    {
        return $this->uso->estado == true ? 'Habilitado' : 'Inhabilitado';
    }

    public function createdAtUsoInfraestructura()
    {
        return optional($this->uso->create_at)->isoFormat('DD/MM/YYYY');
    }

    public function nodoUso()
    {
        return $this->uso->has('actividad.nodo.entidad') ? "Tecnparque Nodo {$this->uso->actividad->nodo->entidad->nombre}" : 'No Registra';
    }

    public function gestorEncargado()
    {
        return $this->uso->has('actividad.gestor.user') ? $this->uso->actividad->gestor->user->present()->userFullName() : 'No Registra';
    }

    public function actividadUsoInfraestructura()
    {
        return $this->uso->has('actividad') ? "{$this->uso->actividad->codigo_actividad} - {$this->uso->actividad->nombre}" : 'No Registra';
    }

    public function faseActividad()
    {
        if ($this->uso->has('actividad.articulacion_proyecto.proyecto.fase') && isset($this->uso->actividad->articulacion_proyecto->proyecto->fase)) {
            return $this->uso->actividad->articulacion_proyecto->proyecto->fase->nombre;
        } else if ($this->uso->has('actividad.articulacion_proyecto.articulacion.fase') && isset($this->uso->actividad->articulacion_proyecto->articulacion->fase)) {
            return $this->uso->actividad->articulacion_proyecto->articulacion->fase->nombre;
        } else {
            return "No Aplica";
        }
    }

    public function asesoriaDirecta()
    {
        if ($this->uso->usogestores->isEmpty()) {
            return 'No registra';
        } else {
            if ($this->uso->usogestores->sum('pivot.asesoria_directa') == 1) {
                return $this->uso->usogestores->sum('pivot.asesoria_directa') . ' hora';
            }
            return $this->uso->usogestores->sum('pivot.asesoria_directa') . ' horas';
        }
    }

    public function asesoriaIndirecta()
    {
        if ($this->uso->usogestores->isEmpty()) {
            return 'No registra';
        } else {
            if ($this->uso->usogestores->sum('pivot.asesoria_indirecta') == 1) {
                return $this->uso->usogestores->sum('pivot.asesoria_indirecta') . ' hora';
            }
            return $this->uso->usogestores->sum('pivot.asesoria_indirecta') . ' horas';
        }
    }
}
