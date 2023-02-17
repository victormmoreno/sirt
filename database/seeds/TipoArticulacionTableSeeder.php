<?php

use Illuminate\Database\Seeder;
use App\Models\TipoArticulacion;

class TipoArticulacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $convenio = TipoArticulacion::where('nombre', 'Convenio')->first();
        if(!is_null($convenio)){
            $convenio->update([
                'nombre' => 'Convenio',
                'descripcion' => 'Convenio con empresas',
                'entidad' => null
            ]);
        }

        $convocatoria = TipoArticulacion::where('nombre', 'Presentación a convocatoria')->first();
        if(!is_null($convocatoria)){
            $convocatoria->update([
                'nombre' => 'Postulación a Convocatorias',
                'descripcion' => 'Convocatoria para Acceso a recursos monetarios o en especie',
                'entidad' => null
            ]);
        }
        $upi = TipoArticulacion::where('nombre', 'UPI')->first();
        if(!is_null($upi)){
            $upi->update([
                'nombre' => 'UPI',
                'descripcion' => 'Procesos de propiedad intelectual apoyado internamente por la unidad de propiedad intelectual',
                'entidad' => 'UPI'
            ]);
        }

        $empresa = TipoArticulacion::where('nombre', 'Creación empresa')->first();
        if(!is_null($empresa)){
            $empresa->update([
                'nombre' => 'Creación empresa',
                'descripcion' => 'Creación de entidad comercial jurídica  - Cámara de comercio y RUT',
                'entidad' => null
            ]);
        }
        $senainnova = TipoArticulacion::where('nombre', 'SENA INNOVA')->first();
        if(!is_null($senainnova)){
            $senainnova->update([
                'nombre' => 'Senainnova',
                'descripcion' => 'Convocatoria Minciencias - SENA INNOVA para empresas',
                'entidad' => 'SENA - Minciencias'
            ]);
        }
        $premio = TipoArticulacion::where('nombre', 'Premio o Reconocimiento')->first();
        if(!is_null($premio)){
            $premio->update([
                'nombre' => 'Concursos - Premios',
                'descripcion' => 'Presentación del PBT en concurso para recibir premio o reconocimiento',
                'entidad' => null
            ]);
        }
        $estrategia = TipoArticulacion::where('nombre', 'ESTRATEGIA METAL-ISI')->first();
        if(!is_null($estrategia)){
            $estrategia->update([
                'nombre' => 'ESTRATEGIA METAL-ISI',
                'descripcion' => 'Desarrollar procesos de innovación en empresas del sector metalmecánico de Santander, que contribuyan con la política de sustitución de importaciones e incentiven la diversificación de la industria.',
                'entidad' => 'Cámara de Comercio de Barrancabermeja'
            ]);
        }
        $incubadora = TipoArticulacion::where('nombre', 'INCUBADORA SEEDLAB')->first();
        if(!is_null($incubadora)){
            $incubadora->update([
                'nombre' => 'INCUBADORA SEEDLAB',
                'descripcion' => 'Identificar, impulsar y desarrollar herramientas para promover a los emprendedores y empresas de la región de Santander iniciativas que contribuyan a la Innovación y diversificación de la industria.',
                'entidad' => 'Emprende  - INNpulsa Colombia'
            ]);
        }
        $alianza = TipoArticulacion::where('nombre', 'Alianza')->first();
        if(!is_null($alianza)){
            $alianza->update([
                'nombre' => 'Alianza con entidades que brinden acceso a uso de equipos y maquinaria de laboratorios de alta tecnología',
                'descripcion' => 'Alianza',
                'entidad' => null
            ]);
        }
        $gestion = TipoArticulacion::where('nombre', 'Gestión Estratégica y Comercial')->first();
        if(!is_null($gestion)){
            $gestion->update([
                'nombre' => 'Gestión Estrategica y Comercial',
                'descripcion' => 'Gestión Estratégica y Comercial',
                'entidad' => null
            ]);
        }
        $fortalecimiento = TipoArticulacion::where('nombre', 'Fortalecimiento de marca o Canales de divulgación')->first();
        if(!is_null($fortalecimiento)){
            $fortalecimiento->update([
                'nombre' => 'Fortalecimiento de marca o Canales de divulgación',
                'descripcion' => 'Fortalecimiento de marca o Canales de divulgación',
                'entidad' => 'Unidad de Divulgación Sennova'
            ]);
        }
    }
}
