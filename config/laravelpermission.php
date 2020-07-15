<?php

return [
    'roles'       => [
        'roleAdministrador' => 'Administrador',
        'roleDinamizador'   => 'Dinamizador',
        'roleGestor'        => 'Gestor',
        'roleInfocenter'    => 'Infocenter',
        'roleTalento'       => 'Talento',
        'roleIngreso'       => 'Ingreso',
        'roleDesarrollador'     => 'Desarrollador',
    ],

    'permissions' => [
        [
            'method'   => 'idea.index',
            'name'     => 'leer ideas',
            'callable' => true,
        ],
        [
            'method'   => 'idea.create',
            'name'     => 'Registrar ideas',
            'callable' => true,
        ],
        [
            'method'   => 'idea.edit',
            'name'     => 'Editar ideas',
            'callable' => true,
        ],
        [
            'method'   => 'idea.delete',
            'name'     => 'Eliminar ideas',
            'callable' => true,
        ],
        [
            'method'   => 'idea.show',
            'name'     => 'ver una ideas',
            'callable' => true,
        ],


    ],
];
