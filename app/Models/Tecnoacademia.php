<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnoacademia extends Model
{
    protected $table = 'tecnoacademias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regional_id',
        'entidad_id',
        'centro_id',
    ];

    
    
    public function regional()
    {
        return $this->belongsTo(Tecnoacademia::class, 'regional_id', 'id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }


    public function centro()
    {
        return $this->belongsTo(Centro::class, 'centro_id', 'id');
    }



}
