<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{

    protected $table = 'tiposdocumentos';

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
      return $this->hasMany(User::class, 'tipodocumento_id', 'id');
    }

    /*==========================================================================
    =            scope para consultar todos los tipos de documentos            =
    ==========================================================================*/
    
    public function scopeAllTipoDocumento($query)
    {

        return $query->select('tiposdocumentos.id','tiposdocumentos.nombre');

    }
    
    /*=====  End of scope para consultar todos los tipos de documentos  ======*/
    
    
}
