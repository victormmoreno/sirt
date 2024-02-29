<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    public function taggable()
    {
        return $this->morphTo();
    }
}
