<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;

class DinamizadorRepository
{
    public function getAllDinamizadoresPorNodo($nodo)
    {
        return User::InfoUserDatatable()
            ->Join('dinamizador', 'dinamizador.user_id', '=', 'users.id')
            ->Join('nodos', 'nodos.id', '=', 'dinamizador.nodo_id')
            ->role(User::IsDinamizador())
            ->where('nodos.id', '=', $nodo);
    }

    public function getAllDinamizadorPorNodoArray($dinamizadoresEloquent)
    {
        $array = array();
        foreach ($dinamizadoresEloquent as $id => $value) {
            $array[$id] = array('email' => $value->email);
        }
        return $array;
    }
}
