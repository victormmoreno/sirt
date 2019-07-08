<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{

	const IS_EGRESADO_SENA = 'Egresado SENA';
	const IS_APRENDIZ_SENA = 'Aprendiz SENA';
    const IS_FUNCIONARIO_EMPRESA_PUBLICA  = 'Funcionario empresa púbilca';
    const IS_EST_UNIVERSITARIO_PREGRADO  = 'Estudiante Universitario de Pregrado';
    const IS_EST_UNIVERSITARIO_POSTGRADO  = 'Estudiante Universitario de Postgrado';
    const IS_FUNCIONARIO_MICROEMPRESA  = 'Funcionario microempresa';
    const IS_FUNCIONARIO_MEDIANA_EMPRESA  = 'Funcionario mediana empresa';
    const IS_FUNCIONARIO_FUNCIONARIO_GRANDE_EMPRESA  = 'Funcionario grande empresa';
    const IS_EMPLEADOR_INDEPENDIENTE  = 'Emprendedor independiente';
    const IS_OTRO  = 'Otro';

    protected $table = 'perfiles';

    protected $fillable = [
        'nombre',
    ];

    /*============================================================
    =            metodos para retornar las constantes            =
    ============================================================*/
    public static function IsEgresadoSena()
    {
        return self::IS_EGRESADO_SENA;
    }
    
    public static function IsAprendizSena()
    {
        return self::IS_APRENDIZ_SENA;
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

    public static function IsEmpleadorIndependiente()
    {
        return self::IS_EMPLEADOR_INDEPENDIENTE;
    }

    public static function IsOtro()
    {
        return self::IS_OTRO;
    }
    
    /*=====  End of metodos para retornar las constantes  ======*/
    


    /*===========================================================================
    =            scope para consultar todos los perfiles del talento            =
    ===========================================================================*/
    public function scopeAllPerfiles($query)
    {

        return $query;
    }
    
    
    /*=====  End of scope para consultar todos los perfiles del talento  ======*/
    
}
