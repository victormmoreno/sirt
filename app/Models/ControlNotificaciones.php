<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ControlNotificaciones extends Model
{
    protected $table = 'control_notificaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'fase_id',
        'remitente_id',
        'rol_remitente_id',
        'receptor_id',
        'rol_receptor_id',
        'fecha_envio',
        'fecha_aceptacion',
        'estado',
        'descripcion'
    ];

    protected $attributes = [
        'estado' => self::IS_PENDIENTE
    ];

    const IS_PENDIENTE = 0;
    const IS_ACEPTADO = 1;
    const IS_RECHAZADO = 2;


    public static function IsPendiente() {
        return self::IS_PENDIENTE;
    }

    public static function IsAceptado() {
        return self::IS_ACEPTADO;
    }

    public static function IsRechazado() {
        return self::IS_RECHAZADO;
    }

    public function notificable()
    {
        return $this->morphTo();
    }

    public function remitente()
    {
        return $this->belongsTo(User::class, 'remitente_id', 'id')->withTrashed();
    }

    public function rol_remitente()
    {
        return $this->belongsTo(Role::class, 'rol_remitente_id', 'id');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_id', 'id')->withTrashed();
    }

    public function rol_receptor()
    {
        return $this->belongsTo(Role::class, 'rol_receptor_id', 'id');
    }

    public function fase()
    {
        return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }
}

