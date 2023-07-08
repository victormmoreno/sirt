<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Contrato extends Model
{
    protected $table = 'contratos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_nodo_id',
        'nodo_id',
        'codigo',
        'fecha_inicio',
        'fecha_finalizacion',
        'valor_contrato',
        'honorarios'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function activador()
    {
        return $this->belongsTo(UserNodo::class, 'user_nodo_id', 'id')->where('role', User::IsActivador());
    }

    public function dinamizador()
    {
        return $this->belongsTo(UserNodo::class, 'user_nodo_id', 'id')->where('role', User::IsDinamizador());
    }

    public function experto()
    {
        return $this->belongsTo(UserNodo::class, 'user_nodo_id', 'id')->where('role', User::IsExperto());
    }

    public function articulador()
    {
        return $this->belongsTo(UserNodo::class, 'user_nodo_id', 'id')->where('role', User::IsArticulador());
    }

    public function infocenter()
    {
        return $this->belongsTo(UserNodo::class, 'user_nodo_id', 'id')->where('role', User::IsInfocenter());
    }

    public function ingreso()
    {
        return $this->belongsTo(UserNodo::class, 'user_nodo_id', 'id')->where('role', User::IsIngreso());
    }

    public function apoyotecnico()
    {
        return $this->belongsTo(UserNodo::class, 'user_nodo_id', 'id')->where('role', User::IsApoyoTecnico());
    }
}
