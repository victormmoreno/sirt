<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroFormacion extends Model
{
    protected $table = 'centrosformacion';

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

    public function regional()
    {
        return $this->belongsTo(Regional::class, 'regional_id', 'id');
    }
}
