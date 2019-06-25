<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ActivationToken extends Model
{
    protected $primaryKey = 'token';
    protected $dates      = ['created_at'];
    protected $fillable   = ['user_id', 'token', 'created_at'];
    public $incrementing  = false;
    public $timestamps    = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
