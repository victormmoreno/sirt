<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
<<<<<<< HEAD
        return view('home');
=======
        // if (auth()->user()->hasRole('Infocenter')) {

            // dd($administradores);
            return view('home');
        // } else if(auth()->user()->hasRole('Dinamizador')){
        //     echo "Infocenter";
        // }else{
        //   abort(403);
        // }



>>>>>>> 6dd3e63e62a96183c85d29f48571d5e51212673e
    }
}
