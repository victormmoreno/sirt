<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaMaterial extends Model
{
    protected $table = 'categoria_material';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre'   => 'string',
    ];


    public function materiales()
	{
        return $this->hasMany(Material::class, 'categoria_material_id', 'id');
	}


    public function getNombreAttribute($nombre)
    {
        return ucwords(strtolower(trim($nombre)));
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(strtolower($nombre));
    }

    /**
     * Execute a query for select a all categorias of materiales.
     *
     * @param  string  $orderBy
     * @return mixed|static
     */
    public function scopeSelectAllCategoriasMateriales($query, string $orderBy)
    {
        return $query->select('nombre','id')
        ->orderBy($orderBy);
    }
}
