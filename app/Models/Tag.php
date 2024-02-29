<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    const IS_ACTIVE = true;
    const IS_INACTIVE = false;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'type',
        'state'
    ];

    /**
     *  return state in system.
     * @return bool
     */
    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }

    /**
     *  return state in system.
     * @return bool
     */
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
    }

    /**
     * Retorna la etiquetas activas
     *
     * @param Query $query
     * @param string $type El tipo de modelo 
     * @return Builder
     * @author dum
     **/
    public function scopeTagsByType($query, $type)
    {
        return $query->where('type', $type)->orderBy('state', 'desc');
    }

    /**
     * Retorna la etiquetas activas
     *
     * @param Query $query
     * @param string $type El tipo de modelo 
     * @return Builder
     * @author dum
     **/
    public function scopeActiveTagsByType($query, $type)
    {
        return $query->where('state', $this->IsActive())->where('type', $type)->orderBy('name');
    }

    // /**
    //  * Retorna la etiquetas seleccionada en un modelo
    //  *
    //  * @param Type $var Description
    //  * @return type
    //  * @throws conditon
    //  **/
    // public function scopeSelectedTagsModel($query, $model)
    // {
    //     return $query->select('tags.id', 'taggable_id AS selected')
    //     ->join('taggables', 'taggables.')
    //     ->where('taggable_id', $model->id)
    //     ->orWhere('taggable_id', null)
    //     ->orderBy('name');
    // }

    public function proyectos()
    {
        return $this->morphedByMany(Proyecto::class, 'taggable');
    }


}
