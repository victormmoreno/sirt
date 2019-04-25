<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'ciudad';

	public $primaryKey= 'idciudad';
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'departamento',
    ];


    public $timestamps = false;

     public function departament()
    {
        
        return $this->belongsTo(Departament::class, 'iddepartamento');
        // return $this->hasMany(Departament::class, 'iddepartamento');
    }

}
