<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    /*=========================================
    =            asesores eloquent            =
    =========================================*/
    public function getHonorariosAttribute($honorarios)
    {
        return trim($honorarios);
    }

    /*=====  End of asesores eloquent  ======*/

    /*========================================
    =            mutador eloquent            =
    ========================================*/
    public function setHonorariosAttribute($honorarios)
    {
        $this->attributes['honorarios'] = trim($honorarios);
    }
}
