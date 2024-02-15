<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    const IS_ACTIVE = true;
    const IS_INACTIVE = false;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'state',
        'options'
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

}
