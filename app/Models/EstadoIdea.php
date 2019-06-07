<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoIdea extends Model
{

    const IS_INICIO = 'Inicio';
    const IS_CONVOCADO = 'Convocado';
    const IS_ADMITIDO  = 'Admitido';
    const IS_NO_ADMITIDO  = 'No Admitido';
    const IS_NO_CONVOCADO  = 'No Convocado';
    const IS_INHABILITADO  = 'Inhabilitado';

    protected $table = 'estadosidea';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;

    public function ideas()
    {
        return $this->hasMany(Ideas::class, 'estadoidea_id', 'id');
    }

    public function scopeFilterEstadoIdea($query,$filtro ,$name='') {
        
        return  $query->select('id','nombre')->where($filtro,'=',$name);

    }
}
