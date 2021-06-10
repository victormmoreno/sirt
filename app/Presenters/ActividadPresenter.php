<?php

namespace App\Presenters;

use App\Models\Actividad;

class ActividadPresenter extends Presenter
{
    protected $actividad;

    public function __construct(Actividad $actividad)
    {
        $this->actividad = $actividad;
    }

    public function actividadNode()
    {
        if ($this->actividad->has('nodo.entidad') && isset($this->actividad->nodo->entidad)) {
            return "Tecnoparque Nodo {$this->actividad->nodo->entidad->nombre}";
        }
        return "No registra";
    }

    public function actividadUserAsesor()
    {
        if ($this->actividad->has('gestor.user') && isset($this->actividad->gestor->user)) {
            return $this->actividad->gestor->user->present()->userFullName();
        }
        return "No registra";
    }

    public function actividadUserRolesAsesor()
    {
        if ($this->actividad->has('gestor.user') && isset($this->actividad->gestor->user)) {
            return $this->actividad->gestor->user->present()->userRolesNames();
        }
        return "No registra";
    }

    public function actividadName()
    {
        if (isset($this->actividad)) {
            return $this->actividad->nombre;
        }
        return "No registra";
    }

    public function actividadCode()
    {
        if (isset($this->actividad)) {
            return $this->actividad->codigo_actividad;
        }
        return "No registra";
    }

    public function startDate(){
        if (isset($this->actividad)) {
            return $this->actividad->fecha_inicio->isoFormat('YYYY-MM-DD');
        }
        return "No registra";
    }
}