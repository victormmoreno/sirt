<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlcanceArticulacion extends Model
{
    protected $table = 'articulation_scopes';


    /**
     * The inverse relation one to much articulations
     *
     * @return void
     */
    public function articulations(){
        return $this->hasMany(Articulation::class, 'scope_id');
    }
}
