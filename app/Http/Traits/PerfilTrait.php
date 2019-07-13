<?php

namespace App\Http\Traits;

trait PerfilTrait {
	/*============================================================
    =            metodos para retornar las constantes            =
    ============================================================*/
    public static function IsEgresadoSena()
    {
        return self::IS_EGRESADO_SENA;
    }
    
    public static function IsAprendizSenaConApoyo()
    {
        return self::IS_APRENDIZ_SENA_CON_APOYO;
    }

    public static function IsAprendizSenaSinApoyo()
    {
        return self::IS_APRENDIZ_SENA_SIN_APOYO;
    }

    public static function IsFuncionarioEmpresaPublica()
    {
        return self::IS_FUNCIONARIO_EMPRESA_PUBLICA;
    }

    public static function IsEstudianteUniversitarioPregrado()
    {
        return self::IS_EST_UNIVERSITARIO_PREGRADO;
    }

    public static function IsEstudianteUniversitarioPostgrado()
    {
        return self::IS_EST_UNIVERSITARIO_POSTGRADO;
    }

    public static function IsFuncionarioMicroempresa()
    {
        return self::IS_FUNCIONARIO_MICROEMPRESA;
    }

    public static function IsFuncionarioMedianaEmpresa()
    {
        return self::IS_FUNCIONARIO_MEDIANA_EMPRESA;
    }

    public static function IsFuncionarioGrandeEmpresa()
    {
        return self::IS_FUNCIONARIO_FUNCIONARIO_GRANDE_EMPRESA;
    }

    public static function IsEmprendedorIndependiente()
    {
        return self::IS_EMPRENDEDOR_INDEPENDIENTE;
    }

    public static function IsInvestigador()
    {
        return self::IS_INVESTIGADOR;
    }

    public static function IsOtro()
    {
        return self::IS_OTRO;
    }
    
    /*=====  End of metodos para retornar las constantes  ======*/
}