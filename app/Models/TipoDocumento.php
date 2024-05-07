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
        'abreviatura',
        'nombre',
    ];

    public function users()
    {
        return $this->hasMany(\App\User::class, 'tipodocumento_id', 'id');
    }

    public function scopeAllTipoDocumento($query)
    {

        return $query->select('tiposdocumentos.id', 'tiposdocumentos.nombre');
    }

    public function visitantes()
    {
        return $this->hasMany(Visitante::class, 'tipodocumento_id', 'id');
    }

    public function scopeGetTiposDocumentos($query)
    {
        return $query->pluck('nombre', 'id');
    }
}
