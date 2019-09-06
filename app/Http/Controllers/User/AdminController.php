<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\AdminRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
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

}
