<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoInvestigacion extends Model
{

    const IS_INTERNO  = 1; //ES INTENERNO SI ES DEL SENA
    const IS_EXTERNO  = 0; //ES EXTERNO SI ES DE OTRA INSTITUCION
    const IS_ACTIVE   = 1; // ES ACTIVO EL GRUPO DE INVESTIGACIÓN
    const IS_INACTIVE = 0; // ES INACTIVO EL GRUPO DE INVESTIGACIÓN

    protected $table = 'gruposinvestigacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entidad_id',
        'clasificacioncolciencias_id',
        'codigo_grupo',
        'tipogrupo',
        'estado',
        'institucion',
        'nombres_contacto',
        'correo_contacto',
        'telefono_contacto',
    ];

    public static function IsInterno()
    {
        return self::IS_INTERNO;
    }
    public static function IsExterno()
    {
        return self::IS_EXTERNO;
    }

    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
    }
}
