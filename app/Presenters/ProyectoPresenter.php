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

    public function proyectoFechaCierre()
    {
        if ($this->proyecto->fase->nombre == 'Suspendido' || $this->proyecto->fase->nombre == 'Cierre') {
            if ($this->proyecto->articulacion_proyecto->actividad->fecha_cierre == null) {
                return "No registra";
            } else {
                return $this->proyecto->articulacion_proyecto->actividad->fecha_cierre->isoFormat('YYYY-MM-DD');
            }
        } else {
            return 'El proyecto no se ha cerrado';
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

}