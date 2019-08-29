<?php

return [
    'roles'       => [
        'roleAdministrador' => 'Administrador',
        'roleDinamizador'   => 'Dinamizador',
        'roleGestor'        => 'Gestor',
        'roleInfocenter'    => 'Infocenter',
        'roleTalento'       => 'Talento',
        'roleIngreso'       => 'Ingreso',
        'roleProveedor'     => 'Proveedor',
    ],

    'permissions' => [
        [
            'method'   => 'user.roleAdministrador.index',
            'name'     => 'Ver Administrador',
            'callable' => true,
        ],
        [
            'method'   => 'idea.index',
            'name'     => 'Ver Ideas',
            'callable' => true,
        ],
        [
            'method'   => 'idea.create',
            'name'     => 'Registrar Idea',
            'callable' => true,
        ],
        [
            'method'   => 'idea.edit',
            'name'     => 'Editar Idea',
            'callable' => true,
        ],
        [
            'method'   => 'idea.delete',
            'name'     => 'Eliminar Idea',
            'callable' => true,
        ],
        [
            'method'   => 'linea.index',
            'name'     => 'Ver Lineas',
            'callable' => true,
        ],
        [
            'method'   => 'linea.create',
            'name'     => 'Registrar Linea',
            'callable' => true,
        ],
        [
            'method'   => 'linea.edit',
            'name'     => 'Editar linea',
            'callable' => true,
        ],
        [
            'method'   => 'linea.delete',
            'name'     => 'Eliminar Linea',
            'callable' => true,
        ],
        [
            'method'   => 'laboratorio.index',
            'name'     => 'Ver Laboratorios',
            'callable' => true,
        ],
        [
            'method'   => 'laboratorio.create',
            'name'     => 'Crear Laboratorio',
            'callable' => true,
        ],
        [
            'method'   => 'laboratorio.edit',
            'name'     => 'Editar Laboratorio',
            'callable' => true,
        ],
        [
            'method'   => 'laboratorio.update',
            'name'     => 'Actualizar Laboratorio',
            'callable' => true,
        ],
        [
            'method'   => 'laboratorio.delete',
            'name'     => 'Eliminar Laboratorio',
            'callable' => true,
        ],

    ],
];
