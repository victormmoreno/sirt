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
    
    ],
];
