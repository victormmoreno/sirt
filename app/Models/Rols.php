<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rols extends Model
{
    protected $table = 'rols';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'rol_id', 'id');
    }
}
