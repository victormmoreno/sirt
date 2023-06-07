<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\User;

class UserNodo extends Model
{
    protected $table = 'user_nodo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nodo_id',
        'linea_id',
        'role',
        'honorarios',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'honorarios' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function linea()
    {
        return $this->belongsTo(LineaTecnologica::class, 'linea_id', 'id');
    }

    public function getHonorariosAttribute($honorarios)
    {
        return trim($honorarios);
    }

    public function setHonorariosAttribute($honorarios)
    {
        $this->attributes['honorarios'] = trim($honorarios);
    }
}
