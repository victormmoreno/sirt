<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactoEntidad extends Model
{
    protected $table = 'contactosentidades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nodo_id',
        'entidad_id',
        'nombres_contacto',
        'correo_contacto',
        'telefono_contacto',
    ];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function getNombresContactoAttribute($nombres_contacto)
    {
        return ucwords(mb_strtolower(trim($nombres_contacto), 'UTF-8'));
    }

    public function getCorreoContactoAttribute($correo_contacto)
    {
        return trim($correo_contacto);
    }

    public function getTelefonoContactoAttribute($telefono_contacto)
    {
        return trim($telefono_contacto);
    }

    public function setNombresContactoAttribute($nombres_contacto)
    {
        $this->attributes['nombres_contacto'] = ucwords(mb_strtolower(trim($nombres_contacto), 'UTF-8'));
    }
    public function setCorreoContactoAttribute($correo_contacto)
    {
        $this->attributes['correo_contacto'] = trim($correo_contacto);
    }
    public function setTelefonoContactoAttribute($telefono_contacto)
    {
        $this->attributes['telefono_contacto'] = trim($telefono_contacto);
    }
}
