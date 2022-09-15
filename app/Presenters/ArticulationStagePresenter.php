<?php

namespace App\Presenters;

use App\Models\ArticulationStage;

class ArticulationStagePresenter extends Presenter
{
    protected $articulationStage;

    public function __construct(ArticulationStage $articulationStage)
    {
        $this->articulationStage = $articulationStage;
    }

    public function articulationStageCode()
    {
        return isset($this->articulationStage->code) ? $this->articulationStage->code : 'No registra';
    }

    public function articulationStageName()
    {
        return isset($this->articulationStage->name) ? $this->articulationStage->name : 'No registra';
    }

    public function articulationStageDescription()
    {
        return isset($this->articulationStage->description) ? $this->articulationStage->description : 'No registra';
    }

    public function articulationStageScope()
    {
        return isset($this->articulationStage->scope) ? $this->articulationStage->scope : 'No registra';
    }

    public function articulationStageBy()
    {
        return isset($this->articulationStage->createdBy) ? $this->articulationStage->createdBy->present()->userFullName() : 'No registra';
    }

    public function articulationStageStatus()
    {
        return $this->articulationStage->status == ArticulationStage::STATUS_OPEN ? __('Open') : __('Close');
    }

    public function articulationStageCreatedDate()
    {
        return optional($this->articulationStage->created_at)->isoFormat('DD/MM/YYYY');
    }


    public function articulationStageStartDate()
    {
        return optional($this->articulationStage->start_date)->isoFormat('DD/MM/YYYY');
    }

    public function articulationStageEndDate()
    {
        return optional($this->articulationStage->end_date)->isoFormat('DD/MM/YYYY');
    }

    public function articulationStageNode()
    {
        return isset($this->articulationStage->node->entidad) ? $this->articulationStage->node->entidad->nombre : 'No Registra';
    }

    public function articulationStageInterlocutorTalent()
    {
        return $this->articulationStage->has('interlocutor') ? $this->articulationStage->interlocutor->present()->userFullName() : 'No Registra';
    }

    public function articulationStageConfidentialityFormat()
    {
        return $this->articulationStage->confidentiality_format ? ($this->articulationStage->confidentiality_format == 1 ? 'Aceptado' : 'No aceptado') : 'No registra';
    }

    public function articulationStageTermsVerifiedAt()
    {
        return optional($this->articulationStage->terms_verified_at)->isoFormat('DD/MM/YYYY');
    }

    public function articulationStageables()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return $item->articulacion_proyecto->actividad->codigo_actividad . ' - '.  $item->articulacion_proyecto->actividad->nombre;
                }
                return "No registra";
            })->implode(',');
        }
    }



    public function articulationStageableLink()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return '<a class="orange-text text-darken-1" target="_blank"  href="'.route('proyecto.detalle', $this->articulationStageableId()).'">'.$this->articulationStageables().'</a>';
                }
            })->implode(',');
        }
    }

    public function articulationStageableId()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return $item->id;
                }
            })->implode(',');
        }
    }

    public function articulationStageableObjetive()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return $item->articulacion_proyecto->actividad->objetivo_general;
                }
            })->implode(',');
        }
    }

    public function articulationStageableEndDate()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return optional($item->articulacion_proyecto->actividad->fecha_cierre)->isoFormat('DD/MM/YYYY');
                }
            })->implode(',');
        }
    }

    public function articulationStageableType()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return "Proyecto";
        }
        else{
            return "No registra";
        }
    }

    public function articulationStageArticulation()
    {
        return $this->articulationStage->articulations->map(function ($item) {
            if(isset($item)){
                return "{$item->code}";
            }
        })->implode(', ');
    }

    public function articulationStageNameConfidentialityFormat()
    {

        if(isset($this->articulationStage->file)){
            if(auth()->user()->can('update', $this->articulationStage)){
                return '<li class="collection-item avatar">
                    <i class="material-icons circle">insert_drive_file</i>
                    <span class="title">'.__('Confidentiality Format').'</span>
                    <p>'.basename( url($this->articulationStage->file->ruta) ).'<br>
                        <a class="orange-text" target="_blank" href='.route('articulation-stage.download', $this->articulationStage).'>Descargar</a>
                    </p><form method="POST" action="'.route('articulation-stage.file.destroy', $this->articulationStage->file).'">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button class="secondary-content red-text">
                            <i class="material-icons">delete_forever</i>
                        </button>
                    </form>
                </li>';
            }else{
                return '<li class="collection-item avatar">
                    <i class="material-icons circle">insert_drive_file</i>
                    <span class="title">'.__('Confidentiality Format').'</span>
                    <p>'.basename( url($this->articulationStage->file->ruta) ).'<br>
                        <a class="orange-text" target="_blank" href='.route('articulation-stage.download', $this->articulationStage).'>Descargar</a>
                    </p>
                </li>';
            }
        }
    }
}
