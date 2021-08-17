<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;
use App\Models\Gestor;

class GestorRepository
{

    // Consulta los expertos de una línea tecnológica por nodo
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
            ->where('nodos.id', '=', $nodo);
    }


    /**
     * Consulta los datos de un experto por el id de la tabla de gestores
     * @param int $id Id del gestor por el que se consultaran los datos
     * @return Collection
     * @author Victor Manuel Moreno Vega
     **/
    public function consultarGestorPorIdGestor($id)
    {
        return Gestor::select('gestores.id')
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
        ->join('users', 'users.id', '=', 'gestores.user_id')
        ->where('gestores.id', $id)
        ->get()
        ->first();
    }

    /**
     * Consulta todos los datos de todos los gestor por nodo
     * @param array $nodo 
     * @return Collection
     * @author devjul
     **/
    public function getInfoGestor(array $relations)
    {
        return Gestor::with($relations);
        
    }
}
