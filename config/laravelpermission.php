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
        'user' => [
        	'roleAdministrador' => [
        		'index' => 'Administrador',
        	],
        ],
        'idea' => [
        	'index' => 'consultar idea',
        	'create' => 'registrar idea',
        	'edit' => 'editar idea',
        	'delete' => 'eliminar idea',

        ],
        'linea' => [
        	'index' => 'consultar linea',
        	'create' => 'registrar linea',
        	'edit' => 'editar linea',
        	'delete' => 'eliminar linea',

        ],


    ],
];
