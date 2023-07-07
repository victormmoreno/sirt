<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjetivoEspecifico extends Model
{

    protected $table = 'objetivos_especificos';
    protected $fillable = [
        'proyecto_id',
        'objetivo',
        'cumplido'
    ];


    public function actividad()
    {
        return $this->belongsTo(Proyecot::class, 'proyecto_id', 'id');
    }
}
