<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoIdea extends Model
{

    const IS_INSCRITO    = 'Inscrito';
    const IS_CONVOCADO    = 'Convocado';
    const IS_ADMITIDO     = 'Admitido';
    const IS_NO_ADMITIDO  = 'No Admitido';
    const IS_NO_CONVOCADO = 'No Convocado';
    const IS_INHABILITADO = 'Inhabilitado';
    const IS_PROYECTO = 'En Proyecto';
    const IS_NO_APLICA = 'No Aplica';
    const IS_PROGRAMADO = 'Programado';
    const IS_REPROGRAMADO = 'Reprogramado';
    const IS_ENVIADO = 'Enviado';

    protected $table = 'estadosidea';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;

    public static function IsInscrito()
    {
        return self::IS_INSCRITO;
    }

    public static function IsConvocado()
    {
        return self::IS_CONVOCADO;
    }

    public static function IsAdmitido()
    {
        return self::IS_ADMITIDO;
    }

    public static function IsNoAdmitido()
    {
        return self::IS_NO_ADMITIDO;
    }

    public static function IsNoConvocado()
    {
        return self::IS_NO_ADMITIDO;
    }

    public static function IsInhabilitado()
    {
        return self::IS_INHABILITADO;
    }

    public static function IsProyecto()
    {
        return self::IS_PROYECTO;
    }

    public static function IsNoAplica()
    {
        return self::IS_NO_APLICA;
    }

    public static function IsProgramado()
    {
        return self::IS_PROGRAMADO;
    }

    public static function IsReprogramado()
    {
        return self::IS_REPROGRAMADO;
    }

    public static function IsEnviado()
    {
        return self::IS_ENVIADO;
    }
}
