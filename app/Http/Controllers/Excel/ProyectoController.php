<?php

namespace App\Http\Controllers\Excel;

use App\Repositories\Repository\ProyectoRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\User;
class ProyectoController extends Controller
{
    private $query;
    private $proyectoRepository;

    public function __construct(ProyectoRepository $proyectoRepository)
    {
        $this->setProyectoRepository($proyectoRepository);
    }

    /**
     * Método para validar el id del nodo que llega
     */
    private function idNodo($id) {
        $idnodo = $id;

        if ( Session::get('login_role') == User::IsDinamizador() ) {
        $idnodo = auth()->user()->dinamizador->nodo_id;
        }
        return $idnodo;
    }

    /**
     * Asigna un valor a $proyectoRepository
     *
     * @param object $proyectoRepository
     * @return void
     * @author dum
     */
    private function setProyectoRepository($proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    /**
     * Retorna el valor de $proyectoRepository
     *
     * @return object
     * @author dum
     */
    private function getProyectoRepository()
    {
        return $this->proyectoRepository;
    }

    /**
     * Asgina un valor a $query
     *
     * @param Collection $query
     * @return void
     * @author dum
     */
    private function setQuery($query) {
        $this->query = $query;
    }

    /**
     * Retorna el valor de $query
     *
     * @return Collection
     * @author dum
     */
    private function getQuery()
    {
        return $this->query;
    }

}
