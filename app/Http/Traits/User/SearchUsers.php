<?php

namespace App\Http\Traits\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UsersRequests\UserSearchRequest;
use App\User;

trait SearchUsers
{
    /**
     * Display the view for to search specified resource (user).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function userSearch()
    {
        if (request()->user()->cannot('search', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.search');
    }

    /**
     * Search specified resource (user).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function querySearchUser(Request $request)
    {
        if (!request()->ajax() || request()->user()->cannot('search', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $req = new UserSearchRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors(),
            ]);
        }
        $users = $this->userRepository->querySearchUser(($request->input('txttype_search') == 1 ? 'documento': 'email'),'LIKE',("%".$request->input('txtsearch_user')."%"))->get();
        if(empty($users)){
            return response()->json([
                'users' => null,
                'status' => Response::HTTP_ACCEPTED,
                'message' => 'el usuario no existe en nuestros registros',
                'url' => route('registro'),
            ], Response::HTTP_ACCEPTED);
        }
        $urls = [];
        foreach($users as $user){
            $urls[] = route('usuario.show', $user->documento);
        };
        return response()->json([
            'users' => $users,
            'message' => 'el usuario ya existe en nuestros registros',
            'status' => Response::HTTP_OK,
            'urls' => $urls,
        ], Response::HTTP_OK);
    }

    public function findCustomerById($id)
    {
        return response()->json(['talento' => User::findOrFail($id)]);
    }

    public function findOfficialById(int $id)
    {
        return response()->json([
            'user' => User::with(['experto', 'experto.linea'])->withTrashed()->where('id', $id)->first(),
        ]);
    }

    public function findExpertsByNodo($nodo = null)
    {
        $experts = User::ConsultarFuncionarios($nodo, User::IsExperto())->get();
        return response()->json([
            'experts' => $experts
        ]);

    }

    public function findFuncionariosByNodo($nodo = null)
    {
        $experts = User::ConsultarFuncionarios($nodo, User::IsExperto())->get();
        $apoyos = User::ConsultarFuncionarios($nodo, User::IsApoyoTecnico())->get();
        $articuladores = User::ConsultarFuncionarios($nodo, User::IsArticulador())->get();
        return response()->json([
            'expertos' => $experts,
            'apoyos' => $apoyos,
            'articuladores' => $articuladores
        ]);

    }

    /**
     * Display the specified resource of talents.
     * todo
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function findUserByDocument($documento)
    {
        $user = User::withTrashed()
            ->ConsultarUsuarios()
            ->where('documento', $documento)
            ->first();
        if (request()->ajax()) {
            if ($user != null) {
                return response()->json([
                    'data' => [
                        'user' => $user,
                        'status_code' => Response::HTTP_OK
                    ]
                ], Response::HTTP_OK);
            }
            return response()->json([
                'data' => [
                    'user' => null,
                    'status_code' => Response::HTTP_NOT_FOUND,
                ]
            ]);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }
}
