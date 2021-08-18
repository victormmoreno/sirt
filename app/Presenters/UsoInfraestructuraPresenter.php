<?php

namespace App\Presenters;

use App\Models\UsoInfraestructura;
use Illuminate\Database\Eloquent\Builder;

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
            ) && isset($this->uso->asesorable->articulacion_proyecto)
        ){
            return  "Proyecto";
        }
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                \App\Models\ArticulacionPbt::class
            ) && isset($this->uso->asesorable->tipoarticulacion)
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
            ) && isset($this->uso->asesorable->articulacion_proyecto)
        ){
            return $this->uso->asesorable->nodo->entidad->nombre;
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\ArticulacionPbt::class]
            ) && isset($this->uso->asesorable->tipoarticulacion)
        ){
            return $this->uso->asesorable->nodo->entidad->nombre;
        }
        return "No registra";
    }

    public function actividadLinea()
    {
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->uso->asesorable->articulacion_proyecto)
        ){
            return $this->uso->asesorable->asesor->lineatecnologica->nombre;
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\ArticulacionPbt::class]
            ) && isset($this->uso->asesorable->tipoarticulacion)
        ){
            return "No registra";
        }
        return "No registra";
    }

    public function expertoEncargado()
    {
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && (isset($this->uso->asesorable->asesor->user) && isset($this->uso->asesorable->articulacion_proyecto))
        ){
            return $this->uso->asesorable->asesor->user->present()->userFullName();
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\ArticulacionPbt::class]
            ) && (isset($this->uso->asesorable->tipoarticulacion) && isset($this->uso->asesorable->asesor))
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



    public function actividadUsoInfraestructura()
    {
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->uso->asesorable->articulacion_proyecto)
        ){
            return "{$this->uso->asesorable->articulacion_proyecto->actividad->codigo_actividad} - {$this->uso->asesorable->articulacion_proyecto->actividad->nombre}";
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\ArticulacionPbt::class]
            ) && isset($this->uso->asesorable->tipoarticulacion)
        ){
            return "{$this->uso->asesorable->present()->articulacionCode()} - {$this->uso->asesorable->present()->articulacionName()}";
        }
        return "No registra";
    }

    public function actividadUsoInfraestructuraStartDate()
    {
        if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class]
            ) && isset($this->uso->asesorable->articulacion_proyecto)
        ){
            return "{$this->uso->asesorable->articulacion_proyecto->actividad->fecha_inicio->isoformat('LL')}";
        }else if(
            $this->uso->whereHasMorph(
                'asesorable',
                [ \App\Models\ArticulacionPbt::class]
            ) && isset($this->uso->asesorable->tipoarticulacion)
        ){
            return "{$this->uso->asesorable->present()->articulacionPbtstartDate()}";
        }
        return "No registra";
    }

    public function faseActividad()
    {
        return $this->uso->asesorable->fase->nombre;
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
