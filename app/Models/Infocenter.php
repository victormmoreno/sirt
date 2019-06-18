<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Infocenter extends Model
{
    protected $table = 'infocenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nodo_id',
        'user_id',
        'extension',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

}
