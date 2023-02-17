<?php

use Illuminate\Database\Seeder;
use App\Models\ArticulationType;
use App\Models\ArticulationSubtype;
use App\Models\Nodo;

class ArticulationSubtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nodos = Nodo::query()->select('id')->get();
        $propiedad_intelectual = ArticulationType::query()->select('id')->where('name', 'Propiedad Intelectual')->first();
        $formalización_empresa = ArticulationType::query()->select('id')->where('name', 'Formalización de empresa o producto')->first();
        $articulacion_empresas = ArticulationType::query()->select('id')->where('name', 'Articulacion con empresas')->first();
        $fortalecimiento_pbt = ArticulationType::query()->select('id')->where('name', 'Fortalecimiento a PBT')->first();

        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Patentes de inveción',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Modelos de utilidad',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Diseños Industriales',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Secretos empresariales',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Marcas',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Esquema de trazado de circuito integrado',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Certificado de obtentor',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derechos de autor - software',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derecho de autor-Planos',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derecho de autor-Croquis',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derechos de autor - obras plásticas relativas a la geografía, topografía entre otros.',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derechos de autor - obras literarias',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derechos de autor - mapas.',
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);



        factory(ArticulationSubtype::class)->create([
            'name' => 'Formalización de empresa persona natural',
            'articulation_type_id' => $formalización_empresa->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Formalización de producto (registro Invima)',
            'articulation_type_id' => $formalización_empresa->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Formalización de empresa persona jurídica',
            'articulation_type_id' => $formalización_empresa->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Creación empresa',
            'articulation_type_id' => $formalización_empresa->id
        ])->nodos()->sync($nodos);

        factory(ArticulationSubtype::class)->create([
            'name' => 'Convenio',
            'articulation_type_id' => $articulacion_empresas->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'ESTRATEGIA METAL-ISI',
            'articulation_type_id' => $articulacion_empresas->id
        ])->nodos()->sync($nodos);


        factory(ArticulationSubtype::class)->create([
            'name' => 'Participación en Ferias',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Postulación a Convocatorias',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Concursos - Premios',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Fortalecimiento de marca o Canales de divulgación',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión en procesos de Transformación Digital',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Internacionalización de Mercados',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión en procesos Logisticos',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión en procesos de TH',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión en procesos de Calidad',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión Estrategica y Comercial',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión de la Productividad',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión Financiera, Contable y Tributaria',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión Ambiental',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Conectar proyecto en búsqueda de negociaciones con empresas y entidades que aporten crecimiento y valor al proyecto',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Alianza con entidades que brinden acceso a uso de equipos y maquinaria de laboratorios de alta tecnología',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Registro Invima de producto',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Registro ICA',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'UPI',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Senainnova',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Colinnova',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'INCUBADORA SEEDLAB',
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);




    }
}
