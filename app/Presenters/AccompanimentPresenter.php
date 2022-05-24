<?php

namespace App\Presenters;

use App\Models\Accompaniment;

class AccompanimentPresenter extends Presenter
{
    protected $accompaniment;

    public function __construct(Accompaniment $accompaniment)
    {
        $this->accompaniment = $accompaniment;
    }

    public function accompanimentCode()
    {
        return isset($this->accompaniment->code) ? $this->accompaniment->code : 'No registra';
    }

    public function accompanimentName()
    {
        return isset($this->accompaniment->name) ? $this->accompaniment->name : 'No registra';
    }

    public function accompanimentDescription()
    {
        return isset($this->accompaniment->description) ? $this->accompaniment->description : 'No registra';
    }

    public function accompanimentScope()
    {
        return isset($this->accompaniment->scope) ? $this->accompaniment->scope : 'No registra';
    }

    public function accompanimentBy()
    {
        return isset($this->accompaniment->createdBy) ? $this->accompaniment->createdBy->present()->userFullName() : 'No registra';
    }

    public function accompanimentStatus()
    {
        return $this->accompaniment->status == Accompaniment::STATUS_OPEN ? __('Open') : __('Close');
    }

    public function accompanimentCreatedDate()
    {
        return optional($this->accompaniment->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a');
    }


    public function accompanimentStartDate()
    {
        return optional($this->accompaniment->start_date)->isoFormat('DD/MM/YYYY');
    }

    public function accompanimentEndDate()
    {
        return optional($this->accompaniment->end_date)->isoFormat('DD/MM/YYYY');
    }

    public function accompanimentNode()
    {
        return $this->accompaniment->has('node.entidad') ? $this->accompaniment->node->entidad->nombre : 'No Registra';
    }

    public function accompanimentInterlocutorTalent()
    {
        return $this->accompaniment->has('interlocutor') ? $this->accompaniment->interlocutor->present()->userFullName() : 'No Registra';
    }

    public function accompanimentConfidentialityFormat()
    {
        return $this->accompaniment->confidentiality_format ? ($this->accompaniment->confidentiality_format == 1 ? 'Aceptado' : 'No aceptado') : 'No registra';
    }

    public function accompanimentTermsVerifiedAt()
    {
        return optional($this->accompaniment->terms_verified_at)->isoFormat('DD/MM/YYYY');
    }

    public function accompanimentables()
    {
        if( $this->accompaniment->projects->count() > 0 &&
            $this->accompaniment->whereHasMorph(
                'accompanimentable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->accompaniment->projects->map(function ($item) {
                if(isset($item)){
                    return $item->articulacion_proyecto->actividad->codigo_actividad . ' - '.  $item->articulacion_proyecto->actividad->nombre;
                }
                return "No registra";
            })->implode(',');
        }
        else if(
            $this->accompaniment->whereHasMorph(
                'accompanimentable',
                [ \App\Models\Sede::class]
            ) && $this->accompaniment->sedes->count() > 0
        ){
            return $this->accompaniment->sedes->map(function ($item) {
                if(isset($item)){
                    return "{$item->nombre_sede} ({$item->empresa->nombre})";
                }
                return "No registra";
            })->implode(',');
        }
    }

    public function accompanimentableType()
    {
        if( $this->accompaniment->projects->count() > 0 &&
            $this->accompaniment->whereHasMorph(
                'accompanimentable',
                [\App\Models\Proyecto::class]
            )
        ){
            return "Proyecto";
        }
        else if(
            $this->accompaniment->whereHasMorph(
                'accompanimentable',
                [ \App\Models\Sede::class]
            ) && $this->accompaniment->sedes->count() > 0
        ){
            return "Sede - Empresa";
        }
    }

    public function accompanimentArticulation()
    {
        return $this->accompaniment->articulations->map(function ($item) {
            if(isset($item)){
                return "{$item->code}";
            }
        })->implode(', ');

    }
}
