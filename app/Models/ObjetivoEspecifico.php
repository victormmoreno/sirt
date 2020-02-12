<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjetivoEspecifico extends Model
{

    protected $table = 'objetivos_especificos';
    protected $fillable = [
        'actividad_id',
        'objetivo',
        'cumplido'
    ];


    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    }
}
