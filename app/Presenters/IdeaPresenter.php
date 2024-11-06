<?php

namespace App\Presenters;

use App\Models\Idea;

class IdeaPresenter extends Presenter
{
    protected $actividad;

    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function ideaCode(){
        if (isset($this->idea)) {
            return $this->idea->codigo_idea;
        }
        return "No registra";
    }

    public function ideaName(){
        if (isset($this->idea)) {
            return $this->idea->datos_idea->nombre_proyecto;
        }
        return "No registra";
    }

    public function isVieneConvocatoriaIdea(){
        if ($this->idea->datos_idea->viene_convocatoria == 1)
        {
            return 1;
        }
        return 0;
    }

    public function ideaVieneConvocatoria(){
        return $this->idea->datos_idea->viene_convocatoria == 1 ? 'Si': 'No';
    }

    public function ideaNombreConvocatoria(){
        return $this->idea->datos_idea->viene_convocatoria == 1 ? $this->idea->convocatoria: 'No Aplica';
    }

    public function ideastartDate(){
        if (isset($this->idea)) {
            return optional($this->idea->created_at)->isoFormat('YYYY-MM-DD');
        }
        return "No registra";
    }

}
