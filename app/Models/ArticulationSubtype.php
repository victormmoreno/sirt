<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\ArticulationSubtypePresenter;

class ArticulationSubtype extends Model
{
    const IS_MOSTRAR = 'Mostrar';
    const IS_OCULTAR = 'Ocultar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'entity',
        'state',
        'articulation_type_id'
    ];



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

    public function articulations(){
        return $this->hasMany(Articulation::class);
    }

    public function nodos()
    {
        return $this->belongsToMany(Nodo::class, 'articulation_subtype_node')
            ->withTimestamps();
    }

    public function scopeState($query, $state)
    {
        if (isset($state) && $state != null && $state != 'all') {
            $query->where('articulation_subtypes.state',  $state);
        }
        return $query;
    }

    public function scopeNode($query, $node)
    {
        if (isset($node) && $node != null && $node != 'all') {
            return $query->where('nodos.id', $node);
        }
        return $query;
    }

    public function scopeNodeForRole($query, $node, $role)
    {
        if (isset($node) && $node != null && $node != 'all' && ($role != User::IsAdministrador() || $role != User::IsActivador() ) ) {
            return $query->whereHas('nodos', function ($subQuery) use ($node) {
                $subQuery->where('nodos.id', $node);
            });
        }
        return $query;
    }
    /**
     * Get the post title.
     *
     * @param  string  $value
     * @return string
     */
    public function getEntityAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Set the post title.
     *
     * @param  string  $value
     * @return string
     */
    public function setEntityAttribute($value)
    {
        $this->attributes['entity'] = json_encode($value);
    }

    public function present()
    {
        return new ArticulationSubtypePresenter($this);
    }

}
