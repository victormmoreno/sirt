<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivationToken extends Model
{
    protected $primaryKey = 'token';
    protected $dates      = ['created_at'];
    protected $fillable   = ['user_id', 'token'];
    public $incrementing  = false;
    public $timestamps    = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
