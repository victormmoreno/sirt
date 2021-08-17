<?php

namespace App\Presenters;

use App\Models\Entidad;

class EntidadPresenter extends Presenter
{
    protected $entidad;

    public function __construct(Entidad $entidad)
    {
        $this->entidad = $entidad;
    }

    public function entidadName()
    {
        if(isset($this->entidad->nombre)){
            return "{$this->entidad->nombre}";
        }
        return $this->message('Información no disponible');

    }

    public function entidadSlug()
    {
        if(isset($this->entidad->slug)){
            return "{$this->entidad->slug}";
        }
        return $this->message('Información no disponible');
    }

    public function entidadEmail()
    {
        if(isset($this->entidad->email_entidad)){
            return "{$this->entidad->email_entidad}";
        }
        return $this->message('Información no disponible');
    }

    public function entidadCity()
    {
        if(isset($this->entidad->ciudad->nombre)){
            return "{$this->entidad->ciudad->nombre}";
        }
        return $this->message('Información no disponible');
    }

    public function entidadDepartamento()
    {
        if(isset($this->entidad->ciudad->departamento->nombre)){
            return "{$this->entidad->ciudad->departamento->nombre}";
        }
        return $this->message('Información no disponible');
    }


    public function entidadLugar()
    {
        return "{$this->entidadCity()} ({$this->entidadDepartamento()})";
    }
}
