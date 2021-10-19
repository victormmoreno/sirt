<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\SupportPresenter;

class Support extends Model
{
    const IS_PENDIENTE = "Pendiente";
    const IS_EN_ESPERA = "En Espera";
    const IS_SOLUCIONADO = "Solucionado";

    protected $fillable = [
        'ticket',
        'name',
        'lastname',
        'document',
        'email',
        'phone',
        'subject',
        'description',
        'difficulty',
        'status'
    ];

    public static function IsPendiente()
    {
        return self::IS_PENDIENTE;
    }

    public static function IsEspera()
    {
        return self::IS_EN_ESPERA;
    }

    public static function IsSolucionado()
    {
        return self::IS_SOLUCIONADO;
    }

    public function getRouteKeyName()
    {
        return 'ticket'; // db column name
    }



    public function scopeCreatedAt($query, $created_at)
    {
        if (!empty($created_at) && $created_at != 'all' && $created_at != null) {
            return $query->whereYear('created_at', $created_at);
        }
        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if (!empty($status) && $status != 'all' && $status != null) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeDifficulty($query, $difficulty)
    {
        if (!empty($difficulty) && $difficulty != 'all' && $difficulty != null) {
            return $query->where('difficulty', $difficulty);
        }
        return $query;
    }

    public function present()
    {
        return new SupportPresenter($this);
    }
}
