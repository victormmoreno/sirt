<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medida;

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
        'codigo_material',
        'nombre',
        'cantidad',
        'valor_compra',
        'proveedor',
        'marca',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nodo_id' => 'integer',
        'lineatecnologica_id'  => 'integer',
        'tipomaterial_id'  => 'integer',
        'categoria_material_id'  => 'integer',
        'presentacion_id'  => 'integer',
        'medida_id'  => 'integer',
        'codigo_material'  => 'string',
        'nombre'  => 'string',
        'cantidad'  => 'float',
        'valor_compra'  => 'float',
        'proveedor'  => 'sgtring', 
        'marca'  => 'string',
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
        $this->attributes['medida_id'] = Medida::find($medida_id) ? medida_id : Medida::create(['nombre' =>  $medida_id])->id;
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

    public function getProveedorAttribute($proveedor)
    {
        return ucwords(mb_strtolower(trim($proveedor),'UTF-8'));
    }

    public function setProveedorAttribute($proveedor)
    {
        $this->attributes['proveedor'] = ucwords(mb_strtolower(trim($proveedor),'UTF-8'));
    }

    public function getMarcaAttribute($marca)
    {
        return ucwords(mb_strtolower(trim($marca),'UTF-8'));
    }

    public function setMarcaAttribute($marca)
    {
        $this->attributes['marca'] = ucwords(mb_strtolower(trim($marca),'UTF-8'));
    }
}
