<?php

namespace App\Http\Controllers\Excel;

use App\Repositories\Repository\{ProyectoRepository, ArticulacionRepository, EdtRepository, UserRepository\TalentoRepository, EmpresaRepository, GrupoInvestigacionRepository};
use App\Http\Controllers\Controller;


class SeguimientoController extends Controller
{

    /**
     * Objeto para la clase ArticulacionRepository
     * @var ArticulacionRepository
     * @author dum
     */
    private $articulacionRepository;

    /**
     * Objeto para la clase EdtRepository
     * @var EdtRepository
     * @author dum
     */
    private $edtRepository;

    /**
     * Objeto para la clase ProyectoRepository
     * @var ProyectoRepository
     * @author dum
     */
    private $proyectoRepository;

    /**
     * Objeto para la clase TalentoRepository
     * @var TalentoRepository
     */
    private  $talentoRepository;

    /**
     * Objeto para la clase EmpresaRepository
     *
     * @var EmpresaRepository
     */
    private $empresaRepository;

    /**
     * undocumented class variable
     *
     * @var GrupoInvestigacionRepository
     */
    private $grupoInvestigacionRepository;

    public function __construct(ProyectoRepository $proyectoRepository, ArticulacionRepository $articulacionRepository, EdtRepository $edtRepository, TalentoRepository $talentoRepository, EmpresaRepository $empresaRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository)
    {
        $this->setArticulacionRepository($articulacionRepository);
        $this->setEdtRepository($edtRepository);
        $this->setProyectoRepository($proyectoRepository);
        $this->setTalentoRepository($talentoRepository);
        $this->setEmpresaRepository($empresaRepository);
        $this->setGrupoInvestigacionRepository($grupoInvestigacionRepository);
    }

    /**
     * Asigna un valor a $articulacionRepository
     * @param ArticulacionRepository
     * @return void
     * @author dum
     */
    private function setArticulacionRepository(ArticulacionRepository $articulacionRepository)
    {
        $this->articulacionRepository = $articulacionRepository;
    }

    /**
     * Retorna el valor de $articulacionRepository
     * @return ArticulacionRepository
     * @author dum
     */
    private function getArticulacionRepository()
    {
        return $this->articulacionRepository;
    }

    /**
     * Asigna un valor a $edtRepository
     * @param EdtRepository $edtRepository
     * @return void
     * @author dum
     */
    private function setEdtRepository(EdtRepository $edtRepository)
    {
        $this->edtRepository = $edtRepository;
    }

    /**
     * Retorna el valor de $edtRepository
     * @return EdtRepository
     * @author dum
     */
    private function getEdtRepository()
    {
        return $this->edtRepository;
    }

    /**
     * Asgina un valor a $proyectoRepository
     * @param ProyectoRepository $proyectoRepository
     * @return void
     * @author dum
     */
    private function setProyectoRepository(ProyectoRepository $proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    /**
     * Retorna el valor de $proyectoRepository
     * @return ProyectoRepository
     * @author dum
     */
    private function getProyectoRepository()
    {
        return $this->proyectoRepository;
    }


    /**
     * Get the value of Objeto para la clase TalentoRepository
    * @return TalentoRepository
    */
    public function getTalentoRepository()
    {
        return $this->talentoRepository;
    }

    /**
     * Set the value of Objeto para la clase TalentoRepository
    * @param TalentoRepository talentoRepository
    */
    public function setTalentoRepository(TalentoRepository $talentoRepository)
    {
        $this->talentoRepository = $talentoRepository;
    }


    /**
     * Get the value of Objeto para la clase EmpresaRepository
    * @return EmpresaRepository
    */
    public function getEmpresaRepository()
    {
        return $this->empresaRepository;
    }

    /**
     * Set the value of Objeto para la clase EmpresaRepository
    * @param EmpresaRepository empresaRepository
    */
    public function setEmpresaRepository(EmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    /**
     * Get the value of Objeto para la clase GrupoInvestigacionRepository
    * @return GrupoInvestigacionRepository
    */
    public function getGrupoInvestigacionRepository()
    {
        return $this->grupoInvestigacionRepository;
    }

    /**
     * Set the value of Objeto para la clase GrupoInvestigacionRepository
    * @param GrupoInvestigacionRepository grupoInvestigacionRepository
    */
    public function setGrupoInvestigacionRepository(GrupoInvestigacionRepository $grupoInvestigacionRepository)
    {
        $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    }
}
