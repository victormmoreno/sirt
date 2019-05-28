<?php

return [
    'production' => [
        ['name' =>PrototiposTableSeeder::class,'callable' => true],
            ['name' =>ServiciosTableSeeder::class,'callable' => true],
            ['name' =>DepartamentosTableSeeder::class,'callable' => true],
        
    ],
 
    'local' => [
        
        ['name' =>PrototiposTableSeeder::class,'callable' => true],
            ['name' =>ServiciosTableSeeder::class,'callable' => true],
            ['name' =>DepartamentosTableSeeder::class,'callable' => true],
            ['name' =>TiposArticulacionesTableSeeder::class,'callable' => true],
            ['name' =>TiposDocumentosTableSeeder::class,'callable' => true],
            ['name' =>CiudadesTableSeeder::class,'callable' => true],
            ['name' =>SectoresTableSeeder::class,'callable' => true],
            ['name' =>TiposMaterialesTableSeeder::class,'callable' => true],
            ['name' =>TiposVinculacionesTableSeeder::class,'callable' => true],
            ['name' =>EstadosIdeasTableSeeder::class,'callable' => true],
            ['name' =>RegionalesTableSeeder::class,'callable' => true],
            ['name' =>CentrosFormacionTableSeeder::class,'callable' => true],
            ['name' =>GenerosTableSeeder::class,'callable' => true],
            ['name' =>NodosTableSeeder::class,'callable' => true],
            ['name' =>EstratosTableSeeder::class,'callable' => true],
            ['name' =>RolsTableSeeder::class, 'callable' => true],//seeder de la tabla vieja
            ['name' =>OcupacionesTableSeeder::class,'callable' => true],
            ['name' =>UsersTableSeeder::class,'callable' => true],
            ['name' =>LineasTableSeeder::class,'callable' => true],
            ['name' =>IdeasTableSeeder::class,'callable' => true],
            ['name' =>NivelesAcademicosTableSeeder::class,'callable' => true],
    ],
];