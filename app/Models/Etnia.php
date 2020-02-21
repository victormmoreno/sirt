<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etnia extends Model
{
    protected $table = 'etnias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'nombre',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'etnia_id', 'id');
    }
}
