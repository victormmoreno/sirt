<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Dinamizador extends Model
{
    protected $table = 'dinamizador';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nodo_id',
        'user_id',
    ];



    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    /*=====  End of relaciones eloquent  ======*/

}
