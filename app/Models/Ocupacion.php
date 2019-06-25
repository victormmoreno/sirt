<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    protected $table = 'ocupaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'ocupaciones_users')
           ->withTimestamps();
    }

    /*==================================================================
    =            scope para consultar todas las ocupaciones            =
    ==================================================================*/
    
    public function scopeAllOcupaciones($query)
    {

        return $query->with('users')->orderby('nombre');
            
    }

    /*=====  End of scope para consultar todas las ocupaciones  ======*/
    
}
