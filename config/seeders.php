<?php

return [
    'production' => [
        ['name' => PrototiposTableSeeder::class, 'callable' => true],
        ['name' => ServiciosTableSeeder::class, 'callable' => true],
        ['name' => DepartamentosTableSeeder::class, 'callable' => true],

    ],

    'local'      => [
        ['name' => RolesTableSeeder::class, 'callable' => true],
        ['name' => TipoTalentosTableSeeder::class, 'callable' => true],
        ['name' => TipoFormacionTableSeeder::class, 'callable' => true],
        ['name' => TipoEstudioTableSeeder::class, 'callable' => true],
        ['name' => TipoEmpresasTableSeeder::class, 'callable' => true],
        ['name' => TiposVisitanteTableSeeder::class, 'callable' => true],
        ['name' => TiposMaterialesTableSeeder::class, 'callable' => true],
        ['name' => TiposEdtTableSeeder::class, 'callable' => true],
        ['name' => TiposDocumentosTableSeeder::class, 'callable' => true],
        ['name' => TiposArticulacionesTableSeeder::class, 'callable' => true],
        ['name' => TamanhoEmpresasTableSeeder::class, 'callable' => true],
        ['name' => ServidorVideosTableSeeder::class, 'callable' => true],
        ['name' => ServiciosTableSeeder::class, 'callable' => true],
        ['name' => SectoresTableSeeder::class, 'callable' => true],
        ['name' => ProductosTableSeeder::class, 'callable' => true],
        ['name' => PresentacionesTableSeeder::class, 'callable' => true],
        ['name' => PerfilesTableSeeder::class, 'callable' => true],
        ['name' => OcupacionesTableSeeder::class, 'callable' => true],

        ['name' => LineasTecnologicasTableSeeder::class, 'callable' => true],

        ['name' => GradosEscolaridadTableSeeder::class, 'callable' => true],
        ['name' => GrupoSanguineosTableSeeder::class, 'callable' => true],
        ['name' => FasesTableSeeder::class, 'callable' => true],
        ['name' => EtniasTableSeeder::class, 'callable' => true],
        ['name' => EstadosProyectoTableSeeder::class, 'callable' => true],
        ['name' => EstadosPrototiposTableSeeder::class, 'callable' => true],
        ['name' => EstadosIdeasTableSeeder::class, 'callable' => true],
        ['name' => EpsTableSeeder::class, 'callable' => true],
        ['name' => ClasificacionesColcienciasTableSeeder::class, 'callable' => true],
        ['name' => DepartamentosTableSeeder::class, 'callable' => true],
        ['name' => CiudadesTableSeeder::class, 'callable' => true],
        ['name' => CategoriaMaterialTableSeeder::class, 'callable' => true],
        ['name' => AreasConocimientoTableSeeder::class, 'callable' => true],


        ['name' => RegionalesTableSeeder::class, 'callable' => true],



        ['name' => EntidadesTableSeeder::class, 'callable' => true],
        ['name' => CostosAdministrativosTableSeeder::class, 'callable' => true],
        ['name' => LaboratoriosTableSeeder::class, 'callable' => true],


        ['name' => UsersTableSeeder::class, 'callable' => true],
        ['name' => PublicacionesTableSeeder::class, 'callable' => true],

    ],
];
