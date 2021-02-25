<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoIdea extends Model
{

    const IS_EN_REGISTRO = 'En registro';
    const IS_CONVOCADO = 'Convocado';
    const IS_ADMITIDO = 'Admitido';
    const IS_RECHAZADO_COMITE  = 'Rechazado por comité';
    const IS_NO_CONVOCADO = 'No Convocado';
    const IS_INHABILITADO = 'Inhabilitado';
    const IS_PBT = 'En PBT';
    const IS_NO_APLICA = 'No Aplica';
    const IS_PROGRAMADO = 'Programado';
    const IS_REPROGRAMADO = 'Reprogramado';
    const IS_POSTULADO = 'Postulado';
    const IS_RECHAZADO_ARTICULADOR = 'Rechazado por articulador';

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

    public static function IsRegistro()
    {
        return self::IS_EN_REGISTRO;
    }

    public static function IsConvocado()
    {
        return self::IS_CONVOCADO;
    }

    public static function IsAdmitido()
    {
        return self::IS_ADMITIDO;
    }

    public static function IsRechazadoComite()
    {
        return self::IS_RECHAZADO_COMITE;
    }

    public static function IsNoConvocado()
    {
        return self::IS_NO_CONVOCADO;
    }

    public static function IsInhabilitado()
    {
        return self::IS_INHABILITADO;
    }

    public static function IsPBT()
    {
        return self::IS_PBT;
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

    public static function IsPostulado()
    {
        return self::IS_POSTULADO;
    }

    public static function IsRechazadoArticulador()
    {
        return self::IS_RECHAZADO_ARTICULADOR;
    }
}
