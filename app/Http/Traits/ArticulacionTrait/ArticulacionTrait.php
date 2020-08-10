<?php

namespace App\Http\Traits\ArticulacionTrait;

trait ArticulacionTrait
{

    // Retorno para la constante de no aplica
    public function IsNoAplica()
    {
        return self::IS_NOAPLICA;
    }

    // Retorno de la constantes para el campo de tipo_articulacion
    public static function IsGrupo()
    {
        return self::IS_GRUPO;
    }

    public static function IsEmpresa()
    {
        return self::IS_EMPRESA;
    }

    public static function IsEmprendedor()
    {
        return self::IS_EMPRENDEDOR;
    }

}
