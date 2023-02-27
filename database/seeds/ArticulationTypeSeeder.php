<?php

use Illuminate\Database\Seeder;
use App\Models\ArticulationType;
use App\Models\TipoArticulacion;

class ArticulationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ArticulationType::class)->create([
            'name' => 'Propiedad Intelectual',
            'description' => __('No register'),
            'state' => ArticulationType::mostrar()
        ]);

        factory(ArticulationType::class)->create([
            'name' => 'Formalización de empresa o producto',
            'description' => __('No register'),
            'state' => ArticulationType::mostrar()
        ]);

        factory(ArticulationType::class)->create([
            'name' => 'Fortalecimiento a PBT',
            'description' => __('No register'),
            'state' => ArticulationType::mostrar()
        ]);

        factory(ArticulationType::class)->create([
            'name' => 'Articulacion con empresas',
            'description' => __('No register'),
            'state' => ArticulationType::ocultar()
        ]);

        //update name of values the table tipo_articulaciones
        $presentacionConvocatoria = TipoArticulacion::where('nombre', 'Presentación a convocatoria')->first();
        if(isset($presentacionConvocatoria))
        {
            $presentacionConvocatoria->update([
                'nombre' => 'Postulación a Convocatorias',
                'descripcion' => 'Convocatoria para Acceso a recursos monetarios o en especie'
            ]);
        }

        $senainnova = TipoArticulacion::where('nombre', 'SENA INNOVA')->first();
        if(isset($senainnova))
        {
            $senainnova->update([
                'nombre' => 'Senainnova'
            ]);
        }
        $premio = TipoArticulacion::where('nombre', 'Premio o Reconocimiento')->first();
        if(isset($premio))
        {
            $premio->update([
                'nombre' => 'Concursos - Premios'
            ]);
        }

        $premio = TipoArticulacion::where('nombre', 'Alianza')->first();
        if(isset($premio))
        {
            $premio->update([
                'nombre' => 'Alianza con entidades que brinden acceso a uso de equipos y maquinaria de laboratorios de alta tecnología'
            ]);
        }
    }
}
