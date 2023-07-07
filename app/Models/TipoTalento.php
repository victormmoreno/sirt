<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTalento extends Model
{

    const IS_APRENDIZ_SENA_CON_APOYO = 'Aprendiz SENA con apoyo de sostenimiento';
    const IS_APRENDIZ_SENA_SIN_APOYO = 'Aprendiz SENA sin apoyo de sostenimiento';
    const IS_EGRESADO_SENA = 'Egresado SENA';
    const IS_INSTRUCTOR_SENA = 'Instructor SENA';
    const IS_FUNCIONARIO_SENA = 'Funcionario SENA';
    const IS_PROPIETARIO_EMPRESA = 'Propietario Empresa';
    const IS_EMPRENDEDOR = 'Emprendedor';
    const IS_ESTUDIANTE_UNIVERSITARIO = 'Estudiante Universitario';
    const IS_FUNCIONARIO_EMPRESA = 'Funcionario de empresa';

    protected $table = 'tipo_talentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre'   => 'string',
    ];
}
