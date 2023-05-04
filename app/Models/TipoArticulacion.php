<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoArticulacion extends Model
{
    const IS_MOSTRAR = 'Mostrar';
    const IS_OCULTAR = 'Ocultar';

    protected $table = 'tipo_articulaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'entidad',
        'estado'
    ];

    public static function mostrar(){
        return self::IS_MOSTRAR;
    }

    public static function ocultar(){
        return self::IS_OCULTAR;
    }

    public function nodos()
    {
        return $this->belongsToMany(Nodo::class, 'nodo_tipoarticulacion')
            ->withTimestamps();
    }


    public function scopeNode($query, $node)
    {
        if (isset($node) && $node != null && $node != 'all') {
            return $query->whereHas('nodos', function ($subQuery) use ($node) {
                $subQuery->where('nodos.id', $node);
            });
        }
        return $query;
    }

    public function scopeState($query, $state)
    {
        if (isset($state) && $state != null && $state != 'all') {
            $query->where('estado',  $state);
        }
        return $query;
    }
}
