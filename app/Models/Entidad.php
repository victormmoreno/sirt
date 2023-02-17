<?php

namespace App\Models;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Presenters\EntidadPresenter;

class Entidad extends Model
{
    protected $table = 'entidades';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ciudad_id',
        'nombre',
        'slug',
        'email_entidad',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ciudad_id'     => 'integer',
        'nombre'        => 'string',
        'slug'          => 'string',
        'email_entidad' => 'string',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getEmailEntidadAttribute($email_entidad)
    {
        return trim($email_entidad);
    }

    public function setEmailEntidadAttribute($email_entidad)
    {
        $this->attributes['email_entidad'] = trim($email_entidad);
    }
    /*=====  End of mutador eloquent  ======*/

    public function setSlugAttribute($nombre)
    {
        $this->attributes['slug'] = Str::slug($nombre, '-');
    }

    /**
     * Relación muchos a muchos con la tabla de edts
     * @return Eloquent
     */
    public function edts()
    {
        return $this->belongsToMany(Edt::class, 'edt_entidad')->withTimestamps();
    }

    public function centro()
    {
        return $this->hasOne(Centro::class, 'entidad_id', 'id');
    }

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'entidad_id', 'id');
    }

    public function grupoinvestigacion()
    {
        return $this->hasOne(GrupoInvestigacion::class, 'entidad_id', 'id');
    }

    public function tecnoacademia()
    {
        return $this->hasOne(Tecnoacademia::class, 'entidad_id', 'id');
    }

    public function nodo()
    {
        return $this->hasOne(Nodo::class, 'entidad_id', 'id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
    }

    public function contactosentidades()
    {
        return $this->hasMany(ContactoEntidad::class, 'entidad_id', 'id');
    }


    public function scopeAllGrupoInvestigacionForCiudad($query, $ciudad)
    {

        return $query->select(['entidades.id', 'entidades.nombre'])
            ->join('gruposinvestigacion', 'gruposinvestigacion.entidad_id', 'entidades.id')
            ->where('entidades.ciudad_id', '=', $ciudad);
    }

    public function present()
    {
        return new EntidadPresenter($this);
    }
}
