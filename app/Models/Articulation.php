<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ArticulationPresenter;

class Articulation extends Model
{

    const START_PHASE = "Inicio";
    const EXECUTION_PHASE = "Ejecución";
    const CLOSING_PHASE = "Cierre";
    const SUSPENDED_PHASE = "Suspendido";
    const FINISHED_PHASE = "Finalizado";

    /**
     * The attributes that guarded.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date'    => 'datetime',
        'end_date'    => 'datetime',
        'expected_end_date'    => 'datetime',
    ];

    /**
     * The attributes that withCount.
     *
     * @var array
     */
    protected $withCount = ['users'];

    /**
     * The inverse relation one to much
     *
     * @return void
     */
    public function accompaniment(){
        return $this->belongsTo(Accompaniment::class, 'accompaniment_id');
    }

    public function users()
    {
        return $this->belongsToMany(\App\User::class, 'articulation_user', 'articulation_id', 'user_id');
    }

    /**
     * The relation one to much scope
     *
     * @return void
     */
    public function scope(){
        return $this->belongsTo(AlcanceArticulacion::class, 'scope_id');
    }

    /**
     * The relation one to much phase
     *
     * @return void
     */
    public function phase(){
        return $this->belongsTo(Fase::class, 'phase_id');
    }

    /**
     * Define an inverse one to many relationship between accompanient and node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by', 'id');
    }


    /**
     * asesor
     */
    public function getProgressAttribute(): int
    {
        $progress = 0;
        isset($this->phase) && $this->phase->nombre == Self::START_PHASE ? $progress = round((100/4)*1, 1) :
        (
            $this->phase->nombre == Self::EXECUTION_PHASE ? $progress = round((100/4)*2, 1) :
            (
                $this->phase->nombre == Self::CLOSING_PHASE ? $progress = round((100/4)*3, 1) :
                (
                    $this->phase->nombre == Self::FINISHED_PHASE ? $progress = round((100/4)*4, 1) : $progress = 0
                )
            )
        );
        return $progress;
    }


    /**
     * The presenter
     *
     * @return void
     */
    public function present()
    {
        return new ArticulationPresenter($this);
    }
}
