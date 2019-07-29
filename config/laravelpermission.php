<?php

return [
    'roles'       => [
        'roleAdministrador' => 'Administrador',
        'roleDinamizador' => 'Dinamizador',
        'roleGestor' => 'Gestor',
        'roleInfocenter' => 'Infocenter',
        'roleTalento' => 'Talento',
        'roleIngreso' => 'Ingreso',
        'roleProveedor' => 'Proveedor',
    ],

    'permissions' => [
        [
            'method' => 'user.roleAdministrador.index',
            'name' => 'ver administrador',
            'callable' => true,
        ],
        [
            'method' => 'idea.index',
            'name' => 'ver ideas',
            'callable' => true,
        ],
        [
            'method' => 'idea.create',
            'name' => 'registrar idea',
            'callable' => true,
        ],
        [
            'method' => 'idea.edit',
            'name' => 'editar idea',
            'callable' => true,
        ],
        [
            'method' => 'idea.delete',
            'name' => 'eliminar idea',
            'callable' => true,
        ],
        [
            'method' => 'linea.index',
            'name' => 'ver lineas',
            'callable' => true,
        ],
        [
            'method' => 'linea.create',
            'name' => 'registrar linea',
            'callable' => true,
        ],
        [
            'method' => 'linea.edit',
            'name' => 'editar linea',
            'callable' => true,
        ],
        [
            'method' => 'linea.delete',
            'name' => 'eliminar linea',
            'callable' => true,
        ],
        // 'user' => [
        // 	'roleAdministrador' => [
        // 		'index' => 'Administrador',
        // 	],
        // ],
        // 'idea' => [
        // 	'index' => 'consultar idea',
        // 	'create' => 'registrar idea',
        // 	'edit' => 'editar idea',
        // 	'delete' => 'eliminar idea',

        // ],
        // 'linea' => [
        // 	'index' => 'consultar linea',
        // 	'create' => 'registrar linea',
        // 	'edit' => 'editar linea',
        // 	'delete' => 'eliminar linea',

        // ],


    ],
];
