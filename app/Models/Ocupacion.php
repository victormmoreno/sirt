<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\OcupacionTrait\OcupacionTrait;


class Ocupacion extends Model
{

    use OcupacionTrait;

    const IS_OTRA_OCUPACION = "Otra";

    protected $table = 'ocupaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'ocupaciones_users')
            ->withTimestamps();
    }

}
