<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoVinculacion extends Model
{
    protected $table = 'tiposvinculaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];


    public function dinamizadoresInfocenters()
    {
        return $this->hasMany(DinamizadorInfocenter::class, 'tipovinculacion_id', 'id');
    }
}
