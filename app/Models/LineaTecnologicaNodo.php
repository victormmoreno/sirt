<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineaTecnologicaNodo extends Model
{
    protected $table = 'lineastecnologicas_nodos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'linea_tecnologica_id',
        'nodo_id',
    ];

    public function lineatecnologica()
    {
        return $this->belongsTo(LineaTecnologica::class, 'linea_tecnologica_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

}
