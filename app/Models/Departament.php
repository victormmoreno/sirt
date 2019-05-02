<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{

    protected $table = 'departamento';

    public $primaryKey = 'iddepartamento';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany(City::class, 'departamento', 'iddepartamento');
    }

}
