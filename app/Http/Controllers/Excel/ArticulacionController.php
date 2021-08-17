<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Articulaciones\{ArticulacionesExport, ArticulacionesNodoExport, ArticulacionesUnicaExport, ArticulacionesFinalizadasExport};
use App\Repositories\Repository\{ArticulacionRepository, EmpresaRepository, GrupoInvestigacionRepository, ArticulacionProyectoRepository};
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;

class ArticulacionController extends Controller
{
    private $articulacionProyectoRepository;
    private $grupoInvestigacionRepository;
    private $articulacionRepository;
    private $empresaRepository;

    public function __construct(ArticulacionRepository $articulacionRepository, EmpresaRepository $empresaRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository, ArticulacionProyectoRepository $articulacionProyectoRepository)
    {
        $this->setArticulacionProyectoRepository($articulacionProyectoRepository);
        $this->setGrupoInvestigacionRepository($grupoInvestigacionRepository);
        $this->setArticulacionRepository($articulacionRepository);
        $this->setEmpresaRepository($empresaRepository);
    }

    /**
     * Genera el excel de las articulaciones que tiene un gestor
     * @param int $id Id del gestor
     * @return Response\Excel
     * @author dum
     */
    public function articulacionesDeUnGestor($id)
    {
        return Excel::download(new ArticulacionesExport($this->getArticulacionRepository(), $id), 'Articulaciones.xls');
    }

    /**
     * General el excel de las articulaciones de un nodo
     * @param int $id Id del nodo
     * @return Response\Excel
     * @author dum
     */
    public function articulacionesDeUnNodo($id)
    {
        return Excel::download(new ArticulacionesNodoExport($this->getArticulacionRepository(), $id), 'Articulaciones.xls');
    }

    /**
     * Retorna el valor de $empresaRepository
     *
     * @return object
     * @author dum
     */
    private function getEmpresaRepository()
    {
        return $this->empresaRepository;
    }

    /**
     * Asgina un valor a $empresaRepository
     *
     * @param object $empresaRepository
     * @return void
     * @author dum
     */
    private function setEmpresaRepository($empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    /**
     * Retorna el valor de $grupoInvestigacionRepository
     * @return object
     * @author dum
     */
    private function getGrupoInvestigacionRepository()
    {
        return $this->grupoInvestigacionRepository;
    }

    /**
     * Asgina un valor a $grupoInvestigacionRepository
     * @param object $grupoInvestigacionRepository
     * @return void
     * @author dum
     */
    private function setGrupoInvestigacionRepository($grupoInvestigacionRepository)
    {
        $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    }

    /**
     * Retorna el valor de $articulacionProyectoRepository
     *
     * @return object
     * @author dum
     */
    private function getArticulacionProyectoRepository()
    {
        return $this->articulacionProyectoRepository;
    }

    /**
     * Asgina un valor a $articulacionProyectoRepository
     *
     * @param object $articulacionProyectoRepository
     * @return void
     * @author dum
     */
    private function setArticulacionProyectoRepository($articulacionProyectoRepository)
    {
        $this->articulacionProyectoRepository = $articulacionProyectoRepository;
    }

    /**
     * Asgina un valor a $articulacionRepository
     * @param object $articulacionRepository
     * @return void
     * @author dum
     */
    private function setArticulacionRepository($articulacionRepository)
    {
        $this->articulacionRepository = $articulacionRepository;
    }

    /**
     * Retorna el valor de $articulacionRepository
     * @return object
     * @author dum
     */
    private function getArticulacionRepository()
    {
        return $this->articulacionRepository;
    }
}
