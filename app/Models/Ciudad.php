<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'departamento_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre'          => 'string',
        'departamento_id' => 'integer',
    ];

    public $timestamps = false;

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'ciudad_id', 'id');
    }

    public function usersdocumentoexpedicion()
    {
        return $this->hasMany(User::class, 'ciudad_expedicion_id', 'id');
    }

    public function regionales()
    {
        return $this->hasMany(Regional::class, 'ciudad_id', 'id');
    }

    public function entidades()
    {
        return $this->hasMany(Entidad::class, 'ciudad_id', 'id');
    }

    public function scopeAllCiudadDepartamento($query, $departamento)
    {

        return $query->select('ciudades.id', 'ciudades.nombre')->where('ciudades.departamento_id', $departamento);

    }
}
