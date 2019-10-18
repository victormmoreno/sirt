<?php

namespace App\Models;

use App\Models\CategoriaMaterial;
use App\Models\Medida;
use App\Models\Presentacion;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nodo_id',
        'lineatecnologica_id',
        'tipomaterial_id',
        'categoria_material_id',
        'presentacion_id',
        'medida_id',
        'fecha',
        'codigo_material',
        'nombre',
        'cantidad',
        'valor_compra',
        'horas_uso_anio',
        'proveedor',
        'marca',
    ];

    protected $dates = [
        'fecha',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nodo_id'               => 'integer',
        'lineatecnologica_id'   => 'integer',
        'tipomaterial_id'       => 'integer',
        'categoria_material_id' => 'integer',
        'presentacion_id'       => 'integer',
        'medida_id'             => 'integer',
        'fecha'                 => 'date:Y-m-d',
        'codigo_material'       => 'string',
        'nombre'                => 'string',
        'cantidad'              => 'float',
        'valor_compra'          => 'float',
        'horas_uso_anio'        => 'integer',
        'proveedor'             => 'sgtring',
        'marca'                 => 'string',
    ];

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function lineatecnologica()
    {
        return $this->belongsTo(LineaTecnologica::class, 'lineatecnologica_id', 'id');
    }

    public function tipomaterial()
    {
        return $this->belongsTo(TipoMaterial::class, 'tipomaterial_id', 'id');
    }

    public function categoriamaterial()
    {
        return $this->belongsTo(CategoriaMaterial::class, 'categoria_material_id', 'id');
    }

    public function presentacion()
    {
        return $this->belongsTo(Presentacion::class, 'presentacion_id', 'id');
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class, 'medida_id', 'id');
    }

    public function usoinfraestructuramaterial()
    {
        return $this->belongsToMany(UsoInfraestructura::class, 'material_uso', 'material_id', 'usoinfraestructura_id')
            ->withTimestamps()
            ->withPivot([
                'costo_material',
                'unidad',
            ]);
    }

    public function getCodigoMaterialAttribute($codigo_material)
    {
        return strtoupper(trim($codigo_material));
    }

    public function setCodigoMaterialAttribute($codigo_material)
    {
        $this->attributes['codigo_material'] = strtoupper(trim($codigo_material));
    }

    public function setMedidaIdAttribute($medida_id)
    {
        $this->attributes['medida_id'] = Medida::find($medida_id) ? $medida_id : Medida::create(['nombre' => $medida_id])->id;
    }

    public function setCategoriaMaterialIdAttribute($categoria_material_id)
    {
        $this->attributes['categoria_material_id'] = CategoriaMaterial::find($categoria_material_id) ? $categoria_material_id : CategoriaMaterial::create(['nombre' => $categoria_material_id])->id;
    }

    public function setPresentacionIdAttribute($presentacion_id)
    {
        $this->attributes['presentacion_id'] = Presentacion::find($presentacion_id) ? $presentacion_id : Presentacion::create(['nombre' => $presentacion_id])->id;
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords(strtolower(trim($nombre)));
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(strtolower($nombre));
    }

    public function getCantidadAttribute($cantidad)
    {
        return trim($cantidad);
    }

    public function setCantidadAttribute($cantidad)
    {
        $this->attributes['cantidad'] = trim($cantidad);
    }

    public function getHorasUsoAnioAttribute($horas_uso_anio)
    {
        return trim($horas_uso_anio);
    }

    public function setHorasUsoAnioAttribute($horas_uso_anio)
    {
        $this->attributes['horas_uso_anio'] = trim($horas_uso_anio);
    }

    public function getProveedorAttribute($proveedor)
    {
        return ucwords(mb_strtolower(trim($proveedor), 'UTF-8'));
    }

    public function setProveedorAttribute($proveedor)
    {
        $this->attributes['proveedor'] = ucwords(mb_strtolower(trim($proveedor), 'UTF-8'));
    }

    public function getMarcaAttribute($marca)
    {
        return ucwords(mb_strtolower(trim($marca), 'UTF-8'));
    }

    public function setMarcaAttribute($marca)
    {
        $this->attributes['marca'] = ucwords(mb_strtolower(trim($marca), 'UTF-8'));
    }

    /**
     * devolve consulta de materiales por nodo.
     *
     * @return array
     * @author devjul
     */
    public function scopeMaterialesForNodo($query, $nodo)
    {

        $query->whereHas('nodo', function ($q) use ($nodo) {
            $q->where('id', $nodo);
        });

    }

    /**
     * devolve consulta de materiales por linea.
     *
     * @return array
     * @author devjul
     */
    public function scopeMaterialesForLineaTecnologica($query, $lineatecnologica)
    {

        $query->whereHas('lineatecnologica', function ($query) use ($lineatecnologica) {
            $query->where('id', $lineatecnologica);
        });

    }

}
