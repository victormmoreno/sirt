<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoIdea extends Model
{
    protected $table = 'estadosideas';

    public $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function ideas()
    {
        return $this->hasMany(Ideas::class, 'estadoidea_id', 'id');
    }

    public function scopeFilterEstadoIdea($query,$filtro ,$name='') {
        // if (trim($name) != '') {
            $query->select('id','nombre')->where($filtro,'=',$name);
        // }
        return $query;
    }
}
