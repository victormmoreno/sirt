<?php

namespace App\Models;


use App\Http\Traits\PerfilTrait\PerfilTrait;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{

    use PerfilTrait;

	const IS_EGRESADO_SENA = 'Egresado SENA';
	const IS_APRENDIZ_SENA_CON_APOYO = 'Aprendiz SENA con apoyo de sostenimiento';
    const IS_APRENDIZ_SENA_SIN_APOYO = 'Aprendiz SENA sin apoyo de sostenimiento';
    const IS_FUNCIONARIO_EMPRESA_PUBLICA  = 'Funcionario empresa púbilca';
    const IS_EST_UNIVERSITARIO_PREGRADO  = 'Estudiante Universitario de Pregrado';
    const IS_EST_UNIVERSITARIO_POSTGRADO  = 'Estudiante Universitario de Postgrado';
    const IS_FUNCIONARIO_MICROEMPRESA  = 'Funcionario microempresa';
    const IS_FUNCIONARIO_MEDIANA_EMPRESA  = 'Funcionario mediana empresa';
    const IS_FUNCIONARIO_FUNCIONARIO_GRANDE_EMPRESA  = 'Funcionario grande empresa';
    const IS_EMPRENDEDOR_INDEPENDIENTE  = 'Emprendedor independiente';
    const IS_INVESTIGADOR = 'Investigador';
    const IS_OTRO  = 'Otro';

    protected $table = 'perfiles';

    protected $fillable = [
        'nombre',
    ];

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/
    
    public function talentos()
    {
      return $this->hasMany(Talento::class, 'perfil_id', 'id');
    }
    
    /*=====  End of relaciones eloquent  ======*/
    

    /*===========================================================================
    =            scope para consultar todos los perfiles del talento            =
    ===========================================================================*/
    public function scopeAllPerfiles($query)
    {

        return $query;
    }
    
    
    /*=====  End of scope para consultar todos los perfiles del talento  ======*/
    
}
