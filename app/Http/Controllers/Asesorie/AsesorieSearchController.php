<?php

namespace App\Http\Controllers\Asesorie;

use App\Http\Controllers\Controller;

class AsesorieSearchController extends Controller
{
    /**
     * Display the view for to search specified resource (user).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function showFormSearch()
    {
        // if (request()->user()->cannot('search', User::class)) {
        //     alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
        //     return redirect()->route('home');
        // }
        return view('asesorias.search');
    }
}
