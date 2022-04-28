<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulation extends Model
{
    /**
     * The inverse relation one to much
     *
     * @return void
     */
    public function accompaniment(){
        return $this->belongsTo(Accompaniment::class, 'accompaniment_id');
    }
}
