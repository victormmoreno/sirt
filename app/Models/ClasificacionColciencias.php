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

    /*=========================================
    =            asesores eloquent            =
    =========================================*/

    public function getNombreAttribute($nombre)
    {
        return ucfirst(strtolower(trim($nombre)));
    }

    /*=====  End of asesores eloquent  ======*/

    /*========================================
    =            mutador eloquent            =
    ========================================*/

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucfirst(mb_strtolower((trim($nombre)),'UTF-8'));
    }

    /*=====  End of mutador eloquent  ======*/

    /*========================================================
    =            metodos para retornar constantes            =
    ========================================================*/

    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
    }

    /*=====  End of metodos para retornar constantes  ======*/

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/

    public function gruposinvestigacion()
    {
        return $this->hasMany(GrupoInvestigacion::class, 'clasificacioncolciencias_id', 'id');
    }

    /*=====  End of relaciones eloquent  ======*/

}
