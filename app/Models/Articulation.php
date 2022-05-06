<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ArticulationPresenter;

class Articulation extends Model
{

    /**
     * The attributes that guarded.
     *
     * @var array
     */
    protected $guarded = ['id', 'phase_id'];



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
     * The presenter
     *
     * @return void
     */
    public function present()
    {
        return new ArticulationPresenter($this);
    }
}
