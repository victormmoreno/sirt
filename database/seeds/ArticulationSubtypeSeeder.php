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
            'description' => 'Propiedad Industrial-Patentes de inveción',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Modelos de utilidad',
            'description' => 'Propiedad Industrial-Modelos de utilidad',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Diseños Industriales',
            'description' => 'Propiedad Industrial-Diseños Industriales',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Secretos empresariales',
            'description' => 'Propiedad Industrial-Secretos empresariales',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Marcas',
            'description' => 'Propiedad Industrial-Marcas',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Esquema de trazado de circuito integrado',
            'description' => 'Propiedad Industrial-Esquema de trazado de circuito integrado',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Propiedad Industrial-Certificado de obtentor',
            'description' => 'Propiedad Industrial-Certificado de obtentor',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derechos de autor - software',
            'description' => 'Derechos de autor - software',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derecho de autor-Planos',
            'description' => 'Derecho de autor-Planos',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derecho de autor-Croquis',
            'description' => 'Derecho de autor-Croquis',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derechos de autor - obras plásticas relativas a la geografía, topografía entre otros.',
            'description' => 'Derechos de autor - obras plásticas relativas a la geografía, topografía entre otros.',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derechos de autor - obras literarias',
            'description' => 'Derechos de autor - obras literarias',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Derechos de autor - mapas.',
            'description' => 'Derechos de autor - mapas.',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $propiedad_intelectual->id
        ])->nodos()->sync($nodos);

        factory(ArticulationSubtype::class)->create([
            'name' => 'Formalización de empresa persona natural',
            'description' => 'Formalización de empresa persona natural',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $formalización_empresa->id
        ])->nodos()->sync($nodos);

        factory(ArticulationSubtype::class)->create([
            'name' => 'Formalización de producto (registro invima)',
            'description' => 'Formalización de producto (registro invima)',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $formalización_empresa->id
        ])->nodos()->sync($nodos);

        factory(ArticulationSubtype::class)->create([
            'name' => 'Formalización de empresa persona juridica',
            'description' => 'Formalización de empresa persona juridica',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $formalización_empresa->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Creación empresa',
            'description' => 'Creación empresa',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $formalización_empresa->id
        ])->nodos()->sync($nodos);

        factory(ArticulationSubtype::class)->create([
            'name' => 'Convenio',
            'description' => 'Convenio',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $articulacion_empresas->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'ESTRATEGIA METAL-ISI',
            'description' => 'ESTRATEGIA METAL-ISI',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $articulacion_empresas->id
        ])->nodos()->sync($nodos);


        factory(ArticulationSubtype::class)->create([
            'name' => 'Participación en Ferias',
            'description' => 'Participación en Ferias',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Postulación a Convocatorias',
            'description' => 'Postulación a Convocatorias',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Concursos - Premios',
            'description' => 'Concursos - Premios',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Fortalecimiento de marca o Canales de divulgación',
            'description' => 'Fortalecimiento de marca o Canales de divulgación',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión en procesos de Transformación Digital',
            'description' => 'Gestión en procesos de Transformación Digital',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Internacionalización de Mercados',
            'description' => 'Internacionalización de Mercados',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión en procesos Logisticos',
            'description' => 'Gestión en procesos Logisticos',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión en procesos de TH',
            'description' => 'Gestión en procesos de TH',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión en procesos de Calidad',
            'description' => 'Gestión en procesos de Calidad',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión Estrategica y Comercial',
            'description' => 'Gestión Estrategica y Comercial',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión de la Productividad',
            'description' =>'Gestión de la Productividad',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión Financiera, Contable y Tributaria',
            'description' => 'Gestión Financiera, Contable y Tributaria',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Gestión Ambiental',
            'description' => 'Gestión Ambiental',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Conectar proyecto en búsqueda de negociaciones con empresas y entidades que aporten crecimiento y valor al proyecto',
            'description' => 'Conectar proyecto en búsqueda de negociaciones con empresas y entidades que aporten crecimiento y valor al proyecto',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Alianza con entidades que brinden acceso a uso de equipos y maquinaria de laboratorios de alta tecnología',
            'description' => 'Alianza con entidades que brinden acceso a uso de equipos y maquinaria de laboratorios de alta tecnología',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Registro Invima de producto',
            'description' => 'Registro Invima de producto',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Registro ICA',
            'description' => 'Registro ICA',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'UPI',
            'description' => 'Unidad de propiedad intelectual',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Senainnova',
            'description' => 'Senainnova',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'Colinnova',
            'description' => 'Colinnova',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);
        factory(ArticulationSubtype::class)->create([
            'name' => 'INCUBADORA SEEDLAB',
            'description' => 'INCUBADORA SEEDLAB',
            'entity' =>  json_encode(__('No register')),
            'state' =>  ArticulationSubtype::mostrar(),
            'articulation_type_id' => $fortalecimiento_pbt->id
        ])->nodos()->sync($nodos);




    }
}
