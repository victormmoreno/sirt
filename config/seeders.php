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
<<<<<<< HEAD
        ['name' => ProductosTableSeeder::class, 'callable' => true],
        ['name' => SublineasTableSeeder::class, 'callable' => true],
        ['name' => CiudadesTableSeeder::class, 'callable' => true],
        ['name' => UsersTableSeeder::class, 'callable' => true],
    
=======
        ['name' => ProductoTableSeeder::class, 'callable' => true],
        ['name' => UsersTableSeeder::class, 'callable' => true],

>>>>>>> 6dd3e63e62a96183c85d29f48571d5e51212673e
    ],
];
