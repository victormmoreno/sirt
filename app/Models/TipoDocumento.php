<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{

    const IS_ACTIVE   = 1;
    const IS_INACTIVE = 0;

    protected $table = 'tiposdocumentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abreviatura',
        'nombre',
        'estado',
    ];

    public static function IsActive()
    {
        return TipoDocumento::IS_ACTIVE;
    }

    public static function IsInactive()
    {
        return TipoDocumento::IS_INACTIVE;
    }

    
}
