<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    protected $table = 'regionales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'codigo_regional',
        'direccion',
        'telefono',
    ];

    public function centrosFormaciones()
    {
        return $this->hasMany(CentroFormacion::class, 'regional_id', 'id');
    }
}
