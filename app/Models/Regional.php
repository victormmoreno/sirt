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

    public function tecnoacademias()
    {
      return $this->hasMany(Tecnoacademia::class, 'regional_id', 'id');
    }

    public function centros()
    {
      return $this->hasMany(Centro::class, 'regional_id', 'id');
    }
}
