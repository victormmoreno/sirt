<?php

namespace App\Http\Controllers\User;

use App\Exports\User\Administrador\AdminUserExport;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\AdminRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use PDF;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class AdminController extends Controller
{

    public $adminRepository;
    public $userRepository;
    public $userdatables;

    public function __construct(AdminRepository $adminRepository, UserRepository $userRepository, UserDatatables $userdatables)
    {
        $this->middleware([
            'auth',
            'role_or_permission:'
            . session()->get('login_role', config('laravelpermission.roles.roleAdministrador')),
        ]);
        $this->adminRepository = $adminRepository;
        $this->userRepository  = $userRepository;
        $this->userdatables = $userdatables;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // return $this->adminRepository->getAllAdministradores()->get();
        $this->authorize('indexAdministrador', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():

                if (request()->ajax()) {
                    $users = $this->adminRepository->getAllAdministradores()->orderBy('id', 'ASC')->get();
                    return $this->userdatables->datatableUsers($request, $users);
                }
                return view('users.administrador.administrador.index', ['view' => 'activos']);
                break;
            default:
                abort('404');
                break;
        }

    }

     public function trash(Request $request)
    {
        $this->authorize('indexAdministrador', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                               
                if (request()->ajax()) {
                    $user = $this->adminRepository->getAllAdministradores()->onlyTrashed()->get();
                    return $this->userdatables->datatableUsers($request, $user);
                }

                return view('users.administrador.administrador.index', ['view' => 'inactivos']);
                break;
            default:
                abort('404');
                break;
        }
    }

    public function exportAdminUser($extension = 'xlsx')
    {
        $this->authorize('exportAdminUser', User::class);
        $user = $this->getData();
        $this->setQuery($user);
        return (new AdminUserExport($this->getQuery()))->download("administradores.{$extension}");
    }

    private function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * Retorna el valor de $query
     * @return object
     * @author dum
     */
    private function getQuery()
    {
        return $this->query;
    }

    /**
     * retorna consulta de administradores
     * @return collection
     * @author dum
     */
    private function getData()
    {
        $role = [User::IsAdministrador()];

        $relations = [
            'tipodocumento'                 => function ($query) {
                $query->select('id', 'nombre');
            },
            'gradoescolaridad'              => function ($query) {
                $query->select('id', 'nombre');
            },
            'gruposanguineo'                => function ($query) {
                $query->select('id', 'nombre');
            },
            'eps'                           => function ($query) {
                $query->select('id', 'nombre');
            },
            'ciudad'                        => function ($query) {
                $query->select('id', 'nombre', 'departamento_id');
            },
            'ciudad.departamento'           => function ($query) {
                $query->select('id', 'nombre');
            },
            'ciudadexpedicion'              => function ($query) {
                $query->select('id', 'nombre', 'departamento_id');
            },
            'ciudadexpedicion.departamento' => function ($query) {
                $query->select('id', 'nombre');
            },
            'ocupaciones',
        ];

        return $this->userRepository->userInfoWithRelations($role, $relations)->get();
    }


    /**
     * descargar pdf administradores
     * @return object
     * @author devjul
     */
    public function downloadPDFAdministrator($extennsion = '.pdf', $orientacion = 'portrait')
    {
        // $this->authorize('downloadCertificatedPlataform', User::class);

        $user = $this->getData();


        $pdf = PDF::loadView('pdf.user.admin.reportListAdministrator', compact('user'));

        $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');

        return $pdf->stream("certificado  " . config('app.name') . $extennsion);
    }


}
