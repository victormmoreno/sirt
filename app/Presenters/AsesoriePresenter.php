<?php

namespace App\Presenters;

use App\Models\UsoInfraestructura;

class AsesoriePresenter extends Presenter
{
    protected $asesorie;

    public function __construct(UsoInfraestructura $asesorie)
    {
        $this->asesorie = $asesorie;
    }

    public function asesorable()
    {
        if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->asesorie->asesorable->codigo_proyecto)
        ){
            return "{$this->asesorie->asesorable->codigo_proyecto} - {$this->asesorie->asesorable->nombre}";
        }else if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && isset($this->asesorie->asesorable->estadoIdea)
        ){
            return "{$this->asesorie->asesorable->present()->IdeaCode()} - {$this->asesorie->asesorable->present()->IdeaName()}";
        }else if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class]
            ) && isset($this->asesorie->asesorable)
        ){
            return "{$this->asesorie->asesorable->present()->articulationCode()} - {$this->asesorie->asesorable->present()->articulationName()}";
        }
        return "No registra";
    }

    public function asesorieNode()
    {
        if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->asesorie->asesorable->codigo_proyecto)
        ){
            return $this->asesorie->asesorable->nodo->entidad->nombre;
        }
        else if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && isset($this->asesorie->asesorable->estadoIdea)
        ){
            return $this->asesorie->asesorable->nodo->entidad->nombre;
        }
        else if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class]
            ) && isset($this->asesorie->asesorable->articulationstage->node)
        ){
            return $this->asesorie->asesorable->articulationstage->node->entidad->nombre;
        }
        return "No registra";
    }

    public function asesorableType()
    {
        if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                \App\Models\Proyecto::class
            ) && isset($this->asesorie->asesorable->codigo_proyecto)
        ){
            return  "Proyecto";
        }
        if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                \App\Models\Idea::class
            ) && isset($this->asesorie->asesorable->estadoIdea)
        ){
            return 'Idea';
        }
        if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                \App\Models\Articulation::class
            ) && isset($this->asesorie->asesorable)
        ){
            return 'Articulación';
        }
        return "No registra";
    }

    public function asesorieStartDate()
    {
        if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->asesorie->asesorable->codigo_proyecto)
        ){
            return "{$this->asesorie->asesorable->fecha_inicio->isoformat('LL')}";
        }else if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && isset($this->asesorie->asesorable->fase)
        ){
            return "{$this->asesorie->asesorable->present()->ideastartDate()}";
        }else if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class]
            ) && isset($this->asesorie->asesorable->phase)
        ){
            return "{$this->asesorie->asesorable->present()->articulationStartDate()}";
        }
        return "No registra";
    }

    public function asesorablePhase()
    {
        if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && isset($this->asesorie->asesorable->estadoIdea)
        ){
            return "{$this->asesorie->asesorable->estadoIdea->nombre}";
        }elseif(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->asesorie->asesorable->fase)
        ){
            return $this->asesorie->asesorable->fase->nombre;
        }elseif(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class]
            ) && isset($this->asesorie->asesorable->phase)
        ){
            return $this->asesorie->asesorable->phase->nombre;
        }else{
            return "No registra";
        }
    }

    public function asesorableRoute()
    {
        if(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && isset($this->asesorie->asesorable->estadoIdea)
        ){
            return route('idea.detalle', $this->asesorie->asesorable->id);
        }elseif(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->asesorie->asesorable->fase)
        ){
            return route('proyecto.detalle', $this->asesorie->asesorable->id);
        }elseif(
            $this->asesorie->whereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class]
            ) && isset($this->asesorie->asesorable->phase)
        ){
            return route('articulations.show', $this->asesorie->asesorable->code);
        }else{
            return "No registra";
        }
    }



}
