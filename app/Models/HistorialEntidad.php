<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class HistorialEntidad extends Model
{
    protected $table = 'historial_entidad';

    protected $fillable = [
        'user_id',
        'movimiento_id',
        'role_id',
        'comentarios',
        'descripcion'
    ];

    // public function historial()
    // {
    //     return $this->hasMany(HistorialEntidad::class, 'role_id', 'id');
    // }

    public function historial_entidad()
    {
        return $this->morphTo();
    }

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
