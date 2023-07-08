<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sublinea extends Model
{
    protected $table = 'sublineas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lineatecnologica_id',
        'nombre',
    ];


    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = strtolower($nombre);
        $this->attributes['nombre'] = ucfirst($nombre);
    }

    public function linea()
    {
        return $this->belongsTo(LineaTecnologica::class, 'lineatecnologica_id', 'id');
    }

    /**
     * Devolver relacion entre sublinea y proyecto
     * @author julian londoño
     */
    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'sublinea_id', 'id');
    }

    public function scopeAllSublineas($query)
    {
        return $query;
    }

    public function scopeSubLineasDeUnaLinea($query, $id)
    {
        return $query->select('sublineas.id')
            ->selectRaw('concat(lineastecnologicas.abreviatura, " - ", sublineas.nombre) AS nombre')
            ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
            ->where('lineastecnologicas.id', $id);
    }
}
