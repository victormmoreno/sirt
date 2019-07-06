<?php

namespace App\Models;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ciudad_id',
        'nombre',
        'email_entidad',
    ];

    public function centro()
    {
        return $this->hasOne(Centro::class, 'entidad_id', 'id');
    }

    // Relacion muchos a muchos con nodos
    public function nodos()
    {
        return $this->belongsToMany(Nodos::class, 'contactosentidades')
            ->withTimestamps()
            ->withPivot('nombres_contacto', 'correo_contacto', 'telefono_contacto');
    }

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'entidad_id', 'id');
    }

    // Relación con la tabla de gruposinvestigacion
    public function grupoinvestigacion()
    {
        return $this->hasOne(GrupoInvestigacion::class, 'entidad_id', 'id');
    }

    public function tecnoacademia()
    {
        return $this->hasOne(Tecnoacademia::class, 'entidad_id', 'id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
    }

    // Relación a la tabla de articulaciones
    public function articulaciones()
    {
      return $this->hasMany(Articulacion::class, 'entidad_id', 'id');
    }

}
