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

    public function present()
    {
        return new SupportPresenter($this);
    }
}
