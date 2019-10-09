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
        'lineatecnologica_nodo_id',
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
        'lineatecnologica_nodo_id' => 'integer',
        'referencia'          => 'string',
        'nombre'              => 'string',
        'marca'               => 'string',
        'costo_adquisicion'   => 'string',
        'vida_util'           => 'integer',
        'anio_compra'         => 'year',
    ];

    /**
     * asesor para el campo referencia.
     * @param $referencia
     */
    public function setReferenciaAttribute($referencia)
    {
        $this->attributes['referencia'] = strtoupper(trim($referencia));
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

    public function equiposmantenimientos()
    {
        return $this->hasMany(EquipoMantenimiento::class, 'equipo_id', 'id');
    }

   

    public function lineatecnologicanodo()
    {
        return $this->belongsTo(LineaTecnologicaNodo::class, 'lineatecnologica_nodo_id', 'id');
    }

    public function usoinfraestructuras()
    {
        return $this->belongsToMany(UsoInfraestructura::class, 'equipo_uso', 'usoinfraestructura_id','equipo_id')
            ->withTimestamps()
            ->withPivot([
                'tiempo',
                'costo_equipo',
            ]);
    }


}
