<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComiteIdea extends Model
{
    protected $table = 'comite_idea';

    protected $casts = [
        'hora' => 'datetime:H-i',
    ];

    protected $fillable = [
        'idea_id',
        'comite_id',
        'hora',
        'admitido',
        'asistencia',
        'observaciones',
        'direccion'
    ];

    public function getAdmitidoAttribute($admitido)
    {
        return trim($admitido);
    }

    public function getAsistenciaAttribute($asistencia)
    {
        return trim($asistencia);
    }

    public function getObservacionesAttribute($observaciones)
    {
        return ucfirst(strtolower(trim($observaciones)));
    }

    public function setAdmitidoAttribute($admitido)
    {
        $this->attributes['admitido'] = trim($admitido);
    }
    public function setAsistenciaAttribute($asistencia)
    {
        $this->attributes['asistencia'] = trim($asistencia);
    }

    public function setObservacionesAttribute($observaciones)
    {
        $this->attributes['observaciones'] = ucfirst(strtolower(trim($observaciones)));
    }
}
