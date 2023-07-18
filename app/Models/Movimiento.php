<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Movimiento extends Model
{
    const IS_APROBAR = 'Aprobó';
    const IS_CERRAR = 'Cerró';
    const IS_REVERSAR = 'Reversó';
    const IS_CAMBIAR  = 'Cambió';
    const IS_NO_APROBAR = 'no aprobó';
    const IS_SOLICITAR_TALENTO = 'solicitó al talento';
    const IS_SOLICITAR_DINAMIZADOR = 'solicitó al dinamizador';
    const IS_POSTULAR = 'postuló';
    const IS_REGISTRAR = 'registró';
    const IS_CALIFICAR = 'calificó';
    const IS_ASIGNAR = 'asignó';
    const IS_DUPLICAR = 'duplicó';
    const IS_INHABILITAR = 'inhabilitó';
    const IS_NOTIFICAR = 'notificó';
    const IS_REASIGNAR = 'reasignó';
    const IS_SUSPENDER = 'canceló';
    const IS_CAMBIAR_INTERLOCUTOR = 'cambió el talento interlocutor';
    const IS_CAMBIAR_TALENTOS = 'cambió los talentos del proyecto';
    protected $table = 'movimientos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movimiento',
        'comentarios'
    ];

    public static function IsAprobar()
    {
        return self::IS_APROBAR;
    }

    public static function IsCerrar()
    {
        return self::IS_CERRAR;
    }

    public static function IsReversar()
    {
        return self::IS_REVERSAR;
    }

    public static function IsCambiar()
    {
        return self::IS_CAMBIAR;
    }

    public static function IsNoAprobar()
    {
        return self::IS_NO_APROBAR;
    }

    public static function IsSolicitarTalento()
    {
        return self::IS_SOLICITAR_TALENTO;
    }

    public static function IsSolicitarDinamizador()
    {
        return self::IS_SOLICITAR_DINAMIZADOR;
    }

    public static function IsPostular()
    {
        return self::IS_POSTULAR;
    }

    public static function IsRegistrar()
    {
        return self::IS_REGISTRAR;
    }

    public static function IsCalificar()
    {
        return self::IS_CALIFICAR;
    }

    public static function IsAsignar()
    {
        return self::IS_ASIGNAR;
    }

    public static function IsDuplicar()
    {
        return self::IS_DUPLICAR;
    }

    public static function IsInhabilitar()
    {
        return self::IS_INHABILITAR;
    }

    public static function IsNotificar()
    {
        return self::IS_NOTIFICAR;
    }

    public static function IsReasignar()
    {
        return self::IS_REASIGNAR;
    }

    public static function IsSuspender()
    {
        return self::IS_SUSPENDER;
    }

    public static function IsCambiarInterlocutor()
    {
        return self::IS_CAMBIAR_INTERLOCUTOR;
    }

    public static function IsCambiarTalentos()
    {
        return self::IS_CAMBIAR_TALENTOS;
    }

    // public function historial()
    // {
    //     return $this->morphMany(HistorialEntidad::class, 'historial_entidad');
    // }

    public function historial()
    {
        return $this->hasMany(HistorialEntidad::class, 'movimiento_id', 'id');
    }

    public function actividades_movimientos()
    {
        return $this->belongsToMany(Actividad::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    public function users_movimientos()
    {
        return $this->belongsToMany(User::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    public function roles_movimientos()
    {
        return $this->belongsToMany(Role::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    public function fases_movimientos()
    {
      return $this->belongsToMany(Fase::class, 'movimientos_actividades_users_roles')
      ->withTimestamps();
    }
}
