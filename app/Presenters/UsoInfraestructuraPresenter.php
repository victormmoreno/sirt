<?php

namespace App\Presenters;

use App\Models\UsoInfraestructura;
use App\Models\Proyecto;

class UsoInfraestructuraPresenter extends Presenter
{
    protected $uso;

    public function __construct(UsoInfraestructura $uso)
    {
        $this->uso = $uso;
    }

    public function tipoUsoInfraestructura()
    {
        if($this->uso->tipo_usoinfraestructura == UsoInfraestructura::IsProyecto()) {
            return  'Proyecto';
        }else if($this->uso->tipo_usoinfraestructura == UsoInfraestructura::IsArticulacion()){
            return 'Articulación';
        }else if($this->uso->tipo_usoinfraestructura == UsoInfraestructura::IsEst()){
            return 'EDT';
        }else{
            return 'No Registra';
        }
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
        if($this->uso->has('actividad.nodo.entidad')){
            return "Tecnparque Nodo {$this->uso->actividad->nodo->entidad->nombre}";
        }
        return 'No Registra';
    }

    public function actividadLinea()
    {
        return $this->uso->has('actividad.gestor.lineatecnologica') ? "{$this->uso->actividad->gestor->lineatecnologica->abreviatura} - {$this->uso->actividad->gestor->lineatecnologica->nombre}" : 'No Registra';
    }

    public function expertoEncargado()
    {
        return "{$this->uso->asesorable->asesor->user->nombres} {$this->uso->asesorable->asesor->user->apellidos}";
    }

    public function actividadUsoInfraestructura()
    {
        if ($this->uso->asesorable_type == Proyecto::class) {
            return "{$this->uso->asesorable->articulacion_proyecto->actividad->codigo_actividad} - {$this->uso->asesorable->articulacion_proyecto->actividad->nombre}";
        } else {
            return 'Otro';
        }
    }

    public function faseActividad()
    {
        return $this->uso->asesorable->fase->nombre;
        // if ($this->uso->whereHasMorph('asesorable.fase')) {
        // }
        // if ($this->uso->has('actividad.articulacion_proyecto.proyecto.fase') && isset($this->uso->actividad->articulacion_proyecto->proyecto->fase)) {
        // } else if ($this->uso->has('actividad.articulacionpbt.fase') && isset($this->uso->actividad->articulacionpbt->fase)) {
        //     return $this->uso->actividad->articulacionpbt->fase->nombre;
        // } else {
        //     return "No Aplica";
        // }
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

    public function usoGestores()
    {
        return $this->uso->has('usogestores.user') ? $this->uso->usogestores->map(function ($item, $key) {
            return $item->user->present()->userTipoDocuento() . ' - ' . $item->user->present()->userFullName() . '- ' . "Asesoria Directa: {$item->pivot->asesoria_directa}, Asesoria Indirecta: {$item->pivot->asesoria_indirecta}";
        })->implode(', ') : 'No Registra';
    }

    public function usoTalentos()
    {
        return $this->uso->has('usotalentos.user') ? $this->uso->usotalentos->map(function ($item, $key) {
            return $item->user->present()->userTipoDocuento() . ' - ' . $item->user->present()->userFullName();
        })->implode(', ') : 'No Registra';
    }

    public function usoMateriales()
    {
        return $this->uso->has('usomateriales') ? $this->uso->usomateriales->map(function ($item, $key) {
            return $item->codigo_material . ' - ' . $item->nombre;
        })->implode(', ') : 'No Registra';
    }

    public function usoEquipos()
    {
        if ($this->uso->has('usoequipos')) {
            $equipos = $this->uso->usoequipos()->withTrashed()->get();

            return $equipos->map(function ($item, $key) {
                return $item->referencia . ' - ' . $item->present()->equipoNombre();
            })->implode(', ');
        }
        return 'No Registra';
    }
}
