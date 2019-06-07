<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talento extends Model
{
    protected $table = 'talentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'perfil_id',
        'entidad_id',
        'ciudad_id',
        'programa',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
