<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;


    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/

    public function ciudades()
    {
        return $this->hasMany(Ciudad::class, 'departamento_id', 'id');
    }

    /*=====  End of relaciones eloquent  ======*/

    /*===============================================================
    =            metodo para consultar los departamentos            =
    ===============================================================*/

    public function scopeAllDepartamentos($query)
    {

        return $query->select('departamentos.id', 'departamentos.nombre');

    }

    /*=====  End of metodo para consultar los departamentos  ======*/

}
