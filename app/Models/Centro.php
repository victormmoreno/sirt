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
        'nombre',
        'codigo_centro',
        'direccion',
        'descripcion',
        'ciudad_id',
        'regional_id',
    ];

    public function regional()
    {
        return $this->belongsTo(Regional::class, 'regional_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
    }

    public function nodos()
    {
        return $this->hasMany(Nodo::class, 'centroformacion_id', 'id');
    }


}
