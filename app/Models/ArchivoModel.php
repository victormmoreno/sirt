<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ArchivoModel extends Model
{

    protected $table = 'archivo_model';

    protected $fillable = [
        'ruta',
        'fase_id'
    ];

    public function archives()
    {
        return $this->morphTo();
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function fase()
    {
        return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }

    public function getDominoAttribute($ruta)
    {
        return Str::lower(trim($ruta));
    }
    public function setDominoAttribute($ruta)
    {
        $this->attributes['ruta'] = Str::lower(trim($ruta));
    }
}

