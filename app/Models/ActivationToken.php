<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ActivationToken extends Model
{
    /**
     * model attributes
     * @var string
     * @author devjul
     */
    protected $primaryKey = 'token';
    protected $dates      = ['created_at'];
    protected $fillable   = ['user_id', 'token', 'created_at'];
    public $incrementing  = false;
    public $timestamps    = false;

    /**
     * Define an inverse one-to-one or many relationship between activation_token and users
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
