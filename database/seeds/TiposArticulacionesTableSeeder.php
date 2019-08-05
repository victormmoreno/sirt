<?php

use App\Models\TipoArticulacion;
use Illuminate\Database\Seeder;
// use App\Models\TipoArticulacion;

class TiposArticulacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoArticulacion::create([
            'id'     => 1,
            'nombre' => 'Vigilancia Tecnológica.',
            'articulado_con' => TipoArticulacion::IsEmpresaEmprendedor(),
        ]);

        TipoArticulacion::create([
            'id'     => 2,
            'nombre' => 'Análisis de Prospectiva.',
            'articulado_con' => TipoArticulacion::IsEmpresaEmprendedor(),
        ]);

        TipoArticulacion::create([
            'id'     => 3,
            'nombre' => 'Reestructuración y diseño de planta.',
            'articulado_con' => TipoArticulacion::IsEmpresaEmprendedor(),
        ]);

        TipoArticulacion::create([
            'id'     => 4,
            'nombre' => 'Estrategias de creación y posicionamiento de marca.',
            'articulado_con' => TipoArticulacion::IsEmpresaEmprendedor(),
        ]);

        TipoArticulacion::create([
            'id'     => 5,
            'nombre' => 'Acompañamiento y gestión en el desarrollo de productos de propiedad intelectual',
            'articulado_con' => TipoArticulacion::IsEmpresaEmprendedor(),
        ]);

        TipoArticulacion::create([
            'id'     => 6,
            'nombre' => 'Formular proyectos I+D+i para convocatorias.',
            'articulado_con' => TipoArticulacion::IsEmpresaEmprendedor(),
        ]);

        TipoArticulacion::create([
            'id'     => 7,
            'nombre' => 'Asesoría a empresa o emprendedor.',
            'articulado_con' => TipoArticulacion::IsEmpresaEmprendedor(),
        ]);

        TipoArticulacion::create([
            'id'     => 8,
            'nombre' => 'Productos resultados de actividades de generación de nuevo conocimiento.',
            'articulado_con' => TipoArticulacion::IsGrupo(),
        ]);

        TipoArticulacion::create([
            'id'     => 9,
            'nombre' => 'Productos resultados de actividades de desarrollo tecnológico e innovación. ',
            'articulado_con' => TipoArticulacion::IsGrupo(),
        ]);

        TipoArticulacion::create([
            'id'     => 10,
            'nombre' => 'Productos resultados de actividades de apropiación social del conocimiento.',
            'articulado_con' => TipoArticulacion::IsGrupo(),
        ]);

        TipoArticulacion::create([
            'id'     => 11,
            'nombre' => 'Productos de actividades relacionadas con la Formación de Recurso Humano en CTeI.',
            'articulado_con' => TipoArticulacion::IsGrupo(),
        ]);

    }
}
