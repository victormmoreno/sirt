<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estrato extends Model
{
    protected $table = 'estratos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estrato',
        'nombre',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'estrato_id', 'id');
    }
}
