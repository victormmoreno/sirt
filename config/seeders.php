<?php

return [
    'production' => [
        ['name' => PrototiposTableSeeder::class, 'callable' => true],
        ['name' => ServiciosTableSeeder::class, 'callable' => true],
        ['name' => DepartamentosTableSeeder::class, 'callable' => true],

    ],

    'local'      => [
        ['name' => GradosEscolaridadTableSeeder::class, 'callable' => true],
        ['name' => ServiciosTableSeeder::class, 'callable' => true],
        ['name' => TiposDocumentosTableSeeder::class, 'callable' => true],
        ['name' => SectoresTableSeeder::class, 'callable' => true],
        ['name' => TiposArticulacionesTableSeeder::class, 'callable' => true],
        ['name' => PerfilesTableSeeder::class, 'callable' => true],
        ['name' => RolsTableSeeder::class, 'callable' => true],
        ['name' => EstadosProyectoTableSeeder::class, 'callable' => true],
        ['name' => DepartamentosTableSeeder::class, 'callable' => true],
        ['name' => LineasTecnologicasTableSeeder::class, 'callable' => true],
        ['name' => ProductosTableSeeder::class, 'callable' => true],
        ['name' => SublineasTableSeeder::class, 'callable' => true],
        ['name' => CiudadesTableSeeder::class, 'callable' => true],
        ['name' => RegionalesTableSeeder::class, 'callable' => true],
        ['name' => EntidadesTableSeeder::class, 'callable' => true],
        ['name' => CentrosTableSeeder::class, 'callable' => true],
        ['name' => NodosTableSeeder::class, 'callable' => true],
        ['name' => UsersTableSeeder::class, 'callable' => true],
    
    ],
];
