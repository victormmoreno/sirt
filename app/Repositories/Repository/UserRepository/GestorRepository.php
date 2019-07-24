<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;

class GestorRepository
{

    // Consulta los gestores de una línea tecnológica por nodo
    public function consultarGestoresPorLineaTecnologicaYNodoRepository($id, $idnodo)
    {
        return User::select('gestores.id')
            ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
            ->join('gestores', 'gestores.user_id', '=', 'users.id')
            ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
            ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
            ->where('nodos.id', $idnodo)
            ->where('lineastecnologicas.id', $id)
            ->get();
    }

    public function getAllGestoresPorNodo($nodo)
    {
        return User::InfoUserDatatable()
            ->Join('gestores', 'gestores.user_id', '=', 'users.id')
            ->Join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
            ->role(User::IsGestor())
            ->where('nodos.id', '=', $nodo)
            ->orderby('users.created_at', 'desc')
            ->get();

    }
}
