<?php

namespace App\Http\Traits\ArticulacionTrait;

trait ArticulacionTrait
{

    // Retorno para la constante de no aplica
    public function IsNoAplica()
    {
        return self::IS_NOAPLICA;
    }

    // Retorno para las constantes del campo revisado_final
    public static function IsPorEvaluar()
    {
        return self::IS_POREVALUAR;
    }

    public static function IsAprobado()
    {
        return self::IS_APROBADO;
    }

    public static function IsNoAprobado()
    {
        return self::IS_NOAPROBADO;
    }

    // Retorno para las constantes del campo estado
    public static function IsInicio()
    {
        return self::IS_INICIO;
    }

    public static function IsEjecucion()
    {
        return self::IS_EJECUCION;
    }

    public static function IsCierre()
    {
        return self::IS_CIERRE;
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
