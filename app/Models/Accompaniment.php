<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accompaniment extends Model
{
    const CONFIDENCIALITY_FORMAT_YES = 1;
    const CONFIDENCIALITY_FORMAT_NO = 0;

    /**
     * The relation one to much
     *
     * @return void
     */
    public function articulations(){
        return $this->hasMany(Articulation::class);
    }

}
