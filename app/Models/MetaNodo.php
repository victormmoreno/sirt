<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaNodo extends Model
{
    protected $table = 'metas_nodo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nodo_id',
        'anho',
        'articulaciones',
        'trl6',
        'trl7_trl8'
    ];

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

}
