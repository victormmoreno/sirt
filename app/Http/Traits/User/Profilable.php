<?php

namespace App\Http\Traits\User;

use App\User;

trait Profilable
{
    /**
     * Show a resource for the profile.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $authUser = $this->userRepository->findUserByDocumentBuilder(auth()->user()->documento)->firstOrFail();
        if (request()->user()->cannot('viewProfile', $authUser)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.profile.index', ['user' => $authUser]);
    }

    public function roles()
    {
        $authUser =  User::query()->with(['roles'])->where('users.id', auth()->user()->id)->firstOrFail();
        if (request()->user()->cannot('viewProfile', $authUser)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.profile.roles', [
            'user'  => $authUser,
            'roles' => $this->userRepository->getAllRoles(),
        ]);
    }

    public function account()
    {
        $authUser = User::query()->with(['roles'])->where('users.id', auth()->user()->id)->firstOrFail();
        if (request()->user()->cannot('viewProfile', $authUser)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.profile.account', [
            'user' => $authUser,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAccount()
    {
        $authUser = User::with(['roles'])->where('users.id', auth()->user()->id)->firstOrFail();;
        if (request()->user()->cannot('viewProfile', $authUser)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.profile.edit', [
            'user'              => $authUser,
            'etnias'            => $this->userRepository->getAllEtnias(),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones()
        ]);
    }

    public function downloadCertificatedPlataform($extension = '.pdf', $orientacion = 'portrait')
    {
        $user = $this->getAuthUserFindByIdEloquent();
        if (request()->user()->cannot('downloadCertificatedPlataform', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return $this->profileRepostory->downloadCertificated($user, $extension, $orientacion);
    }
}
