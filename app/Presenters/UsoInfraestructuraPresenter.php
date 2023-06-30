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
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                \App\Models\Proyecto::class
            ) && isset($this->uso->asesorable->codigo_proyecto)
        ){
            return  "Proyecto";
        }
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                \App\Models\Idea::class
            ) && isset($this->uso->asesorable->estadoIdea)
        ){
            return 'Idea';
        }
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                \App\Models\Articulation::class
            ) && isset($this->uso->asesorable)
        ){
            return 'Articulación';
        }
        return "No registra";
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
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->uso->asesorable->nombre_proyecto)
        ){
            return $this->uso->asesorable->nodo->entidad->nombre;
        }
        else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && isset($this->uso->asesorable->estadoIdea)
        ){
            return $this->uso->asesorable->nodo->entidad->nombre;
        }
        else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class]
            ) && isset($this->uso->asesorable->articulationstage->node)
        ){
            return $this->uso->asesorable->articulationstage->node->entidad->nombre;
        }
        return "No registra";
    }

    public function actividadLinea()
    {
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->uso->asesorable->codigo_proyecto)
        ){
            return $this->uso->asesorable->asesor->lineatecnologica->nombre;
        }
        return "No registra";
    }

    public function expertoEncargado()
    {
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && (isset($this->uso->asesorable->asesor->user) && isset($this->uso->asesorable->codigo_proyecto))
        ){
            return $this->uso->asesorable->asesor->user->present()->userFullName();
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && ( isset($this->uso->asesorable->asesor))
        ){
            return $this->uso->asesorable->asesor->present()->userFullName();
        }
        return "No registra";
    }

    public function asesor()
    {
        if($this->uso->usogestores->isNotEmpty()){
            return $this->uso->usogestores->map(function ($item) {
                if(isset($item)){
                    return $item->present()->userDocumento() . ' - ' . $item->present()->userFullName();
                }
                return "No registra";
            })->implode(', ');
        }
        else if($this->uso->usotalentos->isNotEmpty()){
            return $this->uso->usotalentos->map(function ($item) {
                if(isset($item->user)){
                    return $item->user->present()->userDocumento() . ' - ' . $item->user->present()->userFullName() . ' - Talento';
                }
                return "No registra";
            })->implode(', ');
        }
        return "No registra";
    }



    public function asesorable()
    {
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->uso->asesorable->codigo_proyecto)
        ){
            return "{$this->uso->asesorable->codigo_proyecto} - {$this->uso->asesorable->nombre}";
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && isset($this->uso->asesorable->estadoIdea)
        ){
            return "{$this->uso->asesorable->present()->IdeaCode()} - {$this->uso->asesorable->present()->IdeaName()}";
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [\App\Models\Articulation::class]
            ) && isset($this->uso->asesorable->code)
        ){
            return "{$this->uso->asesorable->present()->articulationCode()} - {$this->uso->asesorable->present()->articulationName()}";
        }
        return "No registra";
    }

    public function asesorableStartDate()
    {
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->uso->asesorable->codigo_proyecto)
        ){
            return "{$this->uso->asesorable->fecha_inicio->isoformat('LL')}";
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && isset($this->uso->asesorable->fase)
        ){
            return "{$this->uso->asesorable->present()->ideastartDate()}";
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class]
            ) && isset($this->uso->asesorable->phase)
        ){
            return "{$this->uso->asesorable->present()->articulationStartDate()}";
        }
        return "No registra";
    }

    public function asesorablePhase()
    {
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Idea::class]
            ) && isset($this->uso->asesorable->estadoIdea)
        ){
            return "{$this->uso->asesorable->estadoIdea->nombre}";
        }elseif(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->uso->asesorable->fase)
        ){
            return $this->uso->asesorable->fase->nombre;
        }elseif(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Articulation::class]
            ) && isset($this->uso->asesorable->phase)
        ){
            return $this->uso->asesorable->phase->nombre;
        }else{
            return "No registra";
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

    public function usoGestores()
    {
        return $this->uso->usogestores->map(function ($item) {
                if(isset($item->user)){
                    return $item->user->present()->userTipoDocuento() . ' - ' . $item->user->present()->userFullName() . '- ' . "Asesoria Directa: {$item->pivot->asesoria_directa}, Asesoria Indirecta: {$item->pivot->asesoria_indirecta}";
                }
                if(isset($item)){
                    return $item->present()->userTipoDocuento() . ' - ' . $item->present()->userFullName() . '- ' . "Asesoria Directa: {$item->pivot->asesoria_directa}, Asesoria Indirecta: {$item->pivot->asesoria_indirecta}";
                }
                return "No registra";

            })->implode(', ');
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
