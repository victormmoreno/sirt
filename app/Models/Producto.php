<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre'
    ];

    public function articulaciones()
    {
        return $this->belongsToMany(Articulacion::class, 'articulaciones_productos')
            ->withTimestamps()
            ->withPivot('logrado');
    }

}
