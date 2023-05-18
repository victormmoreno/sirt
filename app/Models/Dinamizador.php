<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Dinamizador extends Model
{
    protected $table = 'dinamizador';

    //constante para conocer el numero de dinamizadores permitidos por nodo
    const CANT_DINAMIZADOR = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nodo_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }


    public static function cantidadDinamizadoresPermitidosPornodo()
    {
        return self::CANT_DINAMIZADOR;
    }

    /**
     * Devolver cantidad de dinamizadores
     * @author julian londoño
     */
    public function scopeCountDinamizadores($query)
    {
        return $query->count();
    }
}
