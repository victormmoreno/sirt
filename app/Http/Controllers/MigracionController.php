<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
use App\Models\Nodo;
use Maatwebsite\Excel\Facades\Excel;

class MigracionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'disablepreventback', 'role_session:Desarrollador']);
    }

    public function index()
    {
        return view('migrations.index', [
            'nodos' => Nodo::SelectNodo()->get()
        ]);
    }

    public function import(Request $request)
    {
        abort('404');
    }
}
