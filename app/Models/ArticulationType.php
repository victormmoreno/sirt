<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ArticulationTypePresenter;

class ArticulationType extends Model
{
    const IS_MOSTRAR = 'Mostrar';
    const IS_OCULTAR = 'Ocultar';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'state'
    ];

    public static function mostrar(){
        return self::IS_MOSTRAR;
    }

    public static function ocultar(){
        return self::IS_OCULTAR;
    }

    public function articulationsubtypes(){
        return $this->hasMany(ArticulationSubtype::class);
    }

    public function scopeState($query, $state)
    {
        if (isset($state) && $state != null && $state != 'all') {
            $query->where('state',  $state);
        }
        return $query;
    }

    public function present()
    {
        return new ArticulationTypePresenter($this);
    }
}
