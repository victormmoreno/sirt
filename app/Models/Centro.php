<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'centros';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regional_id',
        'entidad_id',
        'ciudad_id',
        'codigo_centro',
        'descripcion',
    ];


    public function regional()
    {
        return $this->belongsTo(Regional::class, 'regional_id', 'id');
    }
    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
    }

    public function tecnoacademias()
    {
      return $this->hasMany(Tecnoacademia::class, 'centro_id', 'id');
    }

    public function nodos()
    {
      return $this->hasMany(Nodo::class, 'centro_id', 'id');
    }

    //  public function nodo()
    // {
    //     return $this->belongsTo(Nodo::class, 'centro_id', 'id');
    // }
}
