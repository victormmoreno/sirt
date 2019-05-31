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
        // ['name' => SectoresTableSeeder::class, 'callable' => true],
        ['name' => TiposArticulacionesTableSeeder::class, 'callable' => true],
        ['name' => PerfilesTableSeeder::class, 'callable' => true],
        ['name' => RolsTableSeeder::class, 'callable' => true],
        ['name' => EstadosProyectoTableSeeder::class, 'callable' => true],
        ['name' => DepartamentosTableSeeder::class, 'callable' => true],
        ['name' => LineasTecnologicasTableSeeder::class, 'callable' => true],
        ['name' => ProductoTableSeeder::class, 'callable' => true],
    
    ],
];
