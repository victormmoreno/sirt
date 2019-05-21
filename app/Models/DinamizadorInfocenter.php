<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinamizadorInfocenter extends Model
{
    protected $table = 'dinamizadorinfocenters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'honorario',
        'profesion',
        'tipovinculacion_id',
        'user_id',
    ];

    /*=========================================
    =            relacion eloquent            =
    =========================================*/
    
    public function tipoVinculacion()
    {
        return $this->belongsTo(TipoVinculacion::class, 'tipovinculacion_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    /*=====  End of relacion eloquent  ======*/
    
    
    

}
