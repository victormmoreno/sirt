<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entidad_id',
        'sector_id',
        'nit',
        'direccion',
        'tipoempresa_id',
        'tamanhoempresa_id',
        'fecha_creacion',
        'codigo_ciiu',
    ];

    /*=========================================
    =            asesores eloquent            =
    =========================================*/
    public function getNitAttribute($nit)
    {
        return trim($nit);
    }

    public function getDireccionAttribute($direccion)
    {
        return ucwords(mb_strtolower(trim($direccion),'UTF-8'));
    }

    /*=====  End of asesores eloquent  ======*/

    /*========================================
    =            mutador eloquent            =
    ========================================*/
    public function setNitAttribute($nit)
    {
        $this->attributes['nit'] = trim($nit);
    }

    public function setDireccionAttribute($direccion)
    {
        $this->attributes['direccion'] = ucwords(mb_strtolower(trim($direccion),'UTF-8'));
    }

    /*=====  End of mutador eloquent  ======*/

    // Relación a la tabla entidades
    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    public function proyectos()
    {
        return $this->morphToMany(Proyecto::class, 'propietario')->withTimestamps();
    }

    // Relación a la tabla de sectores
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id', 'id');
    }
    // Relación a la tabla tipo de empresa
    public function tipoempresa()
    {
        return $this->belongsTo(TipoEmpresa::class, 'tipoempresa_id', 'id');
    }
    // Relación a la tabla tipo de empresa
    public function tamanhoempresa()
    {
        return $this->belongsTo(TamanhoEmpresa::class, 'tamanhoempresa_id', 'id');
    }
    // public function ideas()
    // {
    //   return $this->hasMany(Idea::class, 'empresa_id', 'id');
    // }
}
