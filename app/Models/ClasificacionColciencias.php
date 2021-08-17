<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasificacionColciencias extends Model
{

    const IS_ACTIVE   = 1;
    const IS_INACTIVE = 0;

    protected $table = 'clasificacionescolciencias';

    protected $fillable = [
        'nombre',
    ];

    public function getNombreAttribute($nombre)
    {
        return ucfirst(strtolower(trim($nombre)));
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucfirst(mb_strtolower((trim($nombre)),'UTF-8'));
    }

    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
    }

    public function gruposinvestigacion()
    {
        return $this->hasMany(GrupoInvestigacion::class, 'clasificacioncolciencias_id', 'id');
    }

}
