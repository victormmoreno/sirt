<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{
    protected $table = 'eps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'estado',
    ];

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/
    public function users()
    {
      return $this->hasMany(User::class, 'eps_id', 'id');
    }
    
    
    /*=====  End of relaciones eloquent  ======*/
    
}
