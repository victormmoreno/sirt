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
