<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticulationSubtype extends Model
{
    const IS_MOSTRAR = 'Mostrar';
    const IS_OCULTAR = 'Ocultar';

    public static function mostrar(){
        return self::IS_MOSTRAR;
    }

    public static function ocultar(){
        return self::IS_OCULTAR;
    }

    /**
     * The inverse relation one to much
     *
     * @return void
     */
    public function articulationtype(){
        return $this->belongsTo(ArticulationType::class, 'articulation_type_id');
    }

    public function nodos()
    {
        return $this->belongsToMany(Nodo::class, 'nodo_tipoarticulacion')
            ->withTimestamps();
    }
}
