<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;
use App\Models\Gestor;

class GestorRepository
{

    // Consulta los expertos de una línea tecnológica por nodo
    public function consultarGestoresPorLineaTecnologicaYNodoRepository($id, $idnodo)
    {
        return User::select('gestores.id', 'users.id AS user_id')
            ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) as nombre')
            ->join('gestores', 'gestores.user_id', 'users.id')
            ->role(User::IsExperto())
            ->where('gestores.nodo_id', $idnodo)
            ->where('gestores.lineatecnologica_id', $id)
            ->get();
    }

    public function getAllGestoresPorNodo($nodo)
    {
        return User::InfoUserDatatable()
            ->Join('gestores', 'gestores.user_id', '=', 'users.id')
            ->Join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
            ->role(User::IsExperto())
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
