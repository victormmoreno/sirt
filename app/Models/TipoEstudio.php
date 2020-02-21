<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEstudio extends Model
{
    protected $table = 'tipo_estudio';

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
        return $this->hasMany(Talento::class, 'tipo_estudio_id', 'id');
    }
}
