<?php

namespace App\Models;

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

    public $timestamps = false;

    public function departament()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    public function centrosFormaciones()
    {
        return $this->hasMany(CentroFormacion::class, 'ciudad_id', 'id');
    }
}
