<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    /**
     * define el nombre de la tabla.
     * @var string
     */
    protected $table = 'equipos';

    /**
     * valor permitidos a ingresar. proteccion asignacion masiva de datos
     * @var array
     */
    protected $fillable = [
        'laboratorio_id',
        'codigo_equipo',
        'referencia',
        'nombre',
        'marca',
        'costo_adquisicion',
        'vida_util',
        'anio_compra',
    ];

    

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'laboratorio_id'    => 'integer',
        'codigo_equipo'     => 'string',
        'referencia'        => 'string',
        'nombre'            => 'string',
        'marca'             => 'string',
        'costo_adquisicion' => 'string',
        'vida_util'         => 'boolean',
        'anio_compra'       => 'year',
    ];

    /**
     * asesor para el campo referencia.
     * @param $referencia
     */
    public function setReferenciaAttribute($referencia)
    {
        $this->attributes['referencia'] = strtoupper(trim($referencia), 'UTF-8');
    }

    /**
     * mutador para el campo referencia.
     * @param $referencia
     */
    public function getReferenciaAttribute($referencia)
    {
        return strtoupper(trim($referencia));
    }

    /**
     * asesor para el campo nombre.
     * @param $nombre
     */
    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(mb_strtolower(trim($nombre), 'UTF-8'));
    }

    /**
     * mutador para el campo nombre.
     * @param $nombre
     */
    public function getNombreAttribute($nombre)
    {
        return ucwords(strtolower(trim($nombre)));
    }

    /**
     * asesor para el campo marca.
     * @param $marca
     */
    public function setMarcaAttribute($marca)
    {
        $this->attributes['marca'] = ucwords(mb_strtolower(trim($marca), 'UTF-8'));
    }

    /**
     * mutador para el campo marca.
     * @param $marca
     */
    public function getMarcaAttribute($marca)
    {
        return ucwords(strtolower(trim($marca)));
    }

    /**
     * asesor para el campo costo_adquisicion.
     * @param $costo_adquisicion
     */
    public function setCostoAdquisicionAttribute($costo_adquisicion)
    {
        $this->attributes['costo_adquisicion'] = trim($costo_adquisicion);
    }

    /**
     * mutador para el campo costo_adquisicion.
     * @param $costo_adquisicion
     */
    public function getCostoAdquisicionAttribute($costo_adquisicion)
    {
        return trim($costo_adquisicion);
    }

    /**
     * asesor para el campo vida_util.
     * @param $vida_util
     */
    public function setVidaUtilAttribute($vida_util)
    {
        $this->attributes['vida_util'] = trim($vida_util);
    }

    /**
     * mutador para el campo vida_util.
     * @param $vida_util
     */
    public function getVidaUtilAttribute($vida_util)
    {
        return trim($vida_util);
    }

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'laboratorio_id', 'id');
    }

    public function equiposmantenimientos()
    {
        return $this->hasMany(EquipoMantenimiento::class, 'equipo_id', 'id');
    }


    /**
     * scope para consultar los equipos por codigo_equipo.
     * @param $query
     * @param $codigo_equipo
     */
    public function scopeFindCodigoEquipo($query, $codigo_equipo)
    {
        return $query->where('codigo_equipo',$codigo_equipo);
    }
}
