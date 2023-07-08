<?php

namespace App\Http\Traits\AsesorieTrait;

use App\Models\Material;

trait HasMaterial
{
    public function usomateriales()
    {
        return $this->belongsToMany(Material::class, 'material_uso', 'usoinfraestructura_id', 'material_id')
            ->withTimestamps()
            ->withPivot([
                'costo_material',
                'unidad',
            ]);
    }

    /**
     * Elimina los datos de material_uso
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteUsoMateriales($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->usomateriales()->sync([]);
        }
    }
}
