<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasificacionColciencias extends Model
{
    protected $table = 'clasificacionescolciencias';

    protected $fillable = [
        'nombre',
        'estado',
    ];

    public function gruposinvestigacion()
    {
      return $this->hasMany(GrupoInvestigacion::class, 'clasificacioncolciencias_id', 'id');
    }

}
