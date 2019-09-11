<?php

namespace App\Http\Controllers\User;

use App\Exports\User\Administrador\AdminUserExport;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\AdminRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use PDF;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public $adminRepository;
    public $userRepository;

    public function __construct(AdminRepository $adminRepository, UserRepository $userRepository)
    {
        $this->middleware([
            'auth',
            'role_or_permission:'
            . session()->get('login_role', config('laravelpermission.roles.roleAdministrador')),
        ]);
        $this->adminRepository = $adminRepository;
        $this->userRepository  = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('indexAdministrador', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():

                if (request()->ajax()) {
                    return datatables()->of($this->adminRepository->getAllAdministradores())
                        ->addColumn('detail', function ($data) {

                            $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle" href="#" onclick="UserIndex.detailUser(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

                            return $button;
                        })
                        ->addColumn('edit', function ($data) {
                            if ($data->id != auth()->user()->id) {
                                $button = '<a href="' . route("usuario.usuarios.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                            } else {
                                $button = '<center><span class="new badge" data-badge-caption="ES USTED"></span></center>';
                            }
                            return $button;
                        })
                        ->editColumn('estado', function ($data) {
                            if ($data->estado == User::IsActive()) {
                                return $data->estado = 'Habilitado';
                            } else {
                                return $data->estado = 'Inhabilitado ';
                            }
                        })
                        ->rawColumns(['detail', 'edit'])
                        ->make(true);
                }

                return view('users.administrador.administrador.index');
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

        // $pdf->setEncryption($user->documento);

        return $pdf->stream("certificado  " . config('app.name') . $extennsion);
    }


}
