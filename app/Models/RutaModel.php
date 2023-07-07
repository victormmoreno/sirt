<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RutaModel extends Model
{

    protected $table = 'ruta_model';

    protected $fillable = ['ruta'];

    public function rutamodel()
    {
        return $this->morphTo();
    }

    public function getDominoAttribute($ruta)
    {
        return mb_strtolower(trim($ruta), 'UTF-8');
    }

    public function setDominoAttribute($ruta)
    {
        $this->attributes['ruta'] = mb_strtolower(trim($ruta), 'UTF-8');
    }
}
