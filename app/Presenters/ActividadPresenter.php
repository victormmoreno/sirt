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

    public function endDate(){
        if (isset($this->actividad)) {
            return $this->actividad->fecha_cierre->isoFormat('YYYY-MM-DD');
        }
    }

    public function actividadAprobacionDinamizador()
    {
        if ($this->actividad->aprobacion_dinamizador == 1)
        {
            return 1;
        }
        return 0;
    }

    public function actividadcreatedAt()
    {
        if (isset($this->actividad)) {
            return optional($this->actividad->created_at)->isoFormat('LL');
        }
        return "No registra";
    }

    public function actividadConclusiones()
    {
        if (isset($this->actividad)) {
            return $this->actividad->conclusiones;
        }
        return "No registra";
    }

    public function actividadPrimerObjetivoEspecifico()
    {
        if (isset($this->actividad->objetivos_especificos[0])) {
            return $this->actividad->objetivos_especificos[0]->objetivo;
        }
        return "No registra";
    }

    public function actividadSegundoObjetivoEspecifico()
    {
        if (isset($this->actividad->objetivos_especificos[1])) {
            return $this->actividad->objetivos_especificos[1]->objetivo;
        }
        return "No registra";
    }

    public function actividadTercerObjetivoEspecifico()
    {
        if (isset($this->actividad->objetivos_especificos[2])) {
            return $this->actividad->objetivos_especificos[2]->objetivo;
        }
        return "No registra";
    }

    public function actividadCuartoObjetivoEspecifico()
    {
        if (isset($this->actividad->objetivos_especificos[3])) {
            return $this->actividad->objetivos_especificos[3]->objetivo;
        }
        return "No registra";
    }

    public function isActividadCumplioPrimerObjetivo()
    {
        return $this->actividad->objetivos_especificos[0]->cumplido == 0 ? 'NO' : 'SI';
    }

    public function isActividadCumplioSegundoObjetivo()
    {
        return $this->actividad->objetivos_especificos[1]->cumplido == 0 ? 'NO' : 'SI';
    }

    public function isActividadCumplioTercerObjetivo()
    {
        return $this->actividad->objetivos_especificos[2]->cumplido == 0 ? 'NO' : 'SI';
    }

    public function isActividadCumplioCuartoObjetivo()
    {
        return $this->actividad->objetivos_especificos[3]->cumplido == 0 ? 'NO' : 'SI';
    }

    public function isActividadFormularioFinal()
    {
        if ($this->actividad->formulario_final == 1)
        {
            return 1;
        }
        return 0;
    }

    public function actividadSeguimiento()
    {
        if ($this->actividad->seguimiento == 1)
        {
            return 1;
        }
        return 0;
    }

    public function actividadObjetivoGeneral()
    {
        if (isset($this->actividad->objetivo_general)) {
            return $this->actividad->objetivo_general;
        }
        return "No registra";
    }

}
