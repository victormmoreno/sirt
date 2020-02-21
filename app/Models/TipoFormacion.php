<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFormacion extends Model
{
    protected $table = 'tipo_formacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre'   => 'string',
    ];

    public function talentos()
    {
        return $this->hasMany(Talento::class, 'tipo_formacion_id', 'id');
    }
}
