<?php

return [
    'roles'       => [
        'roleAdministrador' => 'Administrador',
        'roleDinamizador'   => 'Dinamizador',
        'roleExperto'        => 'Experto',
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
            'name'     => 'Registrar idea',
            'callable' => true,
        ],
        [
            'method'   => 'idea.edit',
            'name'     => 'Editar idea',
            'callable' => true,
        ],
        [
            'method'   => 'idea.delete',
            'name'     => 'Eliminar idea',
            'callable' => true,
        ],
        [
            'method'   => 'idea.show',
            'name'     => 'ver idea',
            'callable' => true,
        ],


    ],
];
