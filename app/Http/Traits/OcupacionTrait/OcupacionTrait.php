<?php

namespace App\Http\Traits\OcupacionTrait;

trait OcupacionTrait
{
    /*==================================================================
    =            scope para consultar todas las ocupaciones            =
    ==================================================================*/

    public function scopeAllOcupaciones($query)
    {

        return $query->with('users')->orderby('nombre');

    }

    /*=====  End of scope para consultar todas las ocupaciones  ======*/

    /*==========================================
    =            accesores eloquent            =
    ==========================================*/
    public function getNombreAttribute($nombre)
    {
        return ucwords(mb_strtolower(trim($nombre), 'UTF-8'));
    }

    /*=====  End of accesores eloquent  ======*/

    /*==========================================
    =            mutadores eloquent            =
    ==========================================*/

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(mb_strtolower(trim($nombre), 'UTF-8'));
    }

    /*=====  End of mutadores eloquent  ======*/

    /*=======================================================
    =            metodo para retornar constantes            =
    =======================================================*/

    public static function IsOtraOcupacion()
    {
        return self::IS_OTRA_OCUPACION;
    }

    /*=====  End of metodo para retornar constantes  ======*/
}
