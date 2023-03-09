<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Presenters\EquipoPresenter;


class Equipo extends Model
{
    use SoftDeletes;
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
        'nodo_id',
        'lineatecnologica_id',
        'destacado',
        'referencia',
        'nombre',
        'marca',
        'costo_adquisicion',
        'vida_util',
        'anio_compra',
        'horas_uso_anio',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'nodo_id'             => 'integer',
        'lineatecnologica_id' => 'integer',
        'referencia'          => 'string',
        'nombre'              => 'string',
        'marca'               => 'string',
        'costo_adquisicion'   => 'string',
        'vida_util'           => 'integer',
        'anio_compra'         => 'year',
        'horas_uso_anio'      => 'integer',
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

    public function lineatecnologica()
    {
        return $this->belongsTo(LineaTecnologica::class, 'lineatecnologica_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function usoinfraestructuras()
    {
        return $this->belongsToMany(UsoInfraestructura::class, 'equipo_uso', 'equipo_id', 'usoinfraestructura_id')
            ->withTimestamps()
            ->withPivot([
                'tiempo',
                'costo_equipo',
                'costo_administrativo',
            ]);
    }

    /*SCOPES*/

    public function scopeDeletedAt($query, String $state)
    {
        if (!empty($state) && $state != null && $state != 'all') {
            if ($state == 'si') {
                return $query;
            } else {
                return $query->onlyTrashed();
            }
        }
        return $query->withTrashed();
    }

    public function scopeNodoEquipo($query, $nodo)
    {
        if (isset($nodo) && $nodo != null && $nodo != 'all') {
            return $query->where('nodo_id', $nodo);
        }
        return $query;
    }

    public function scopeLineaEquipo($query, $linea)
    {
        if (isset($linea) && $linea != null && $linea != 'all') {
            return $query->where('lineatecnologica_id', $linea);
        }
        return $query;
    }

    public function present()
    {
        return new EquipoPresenter($this);
    }
}
