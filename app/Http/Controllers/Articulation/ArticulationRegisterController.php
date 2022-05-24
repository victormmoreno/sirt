<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articulation;
use App\Models\Accompaniment;
use App\Models\AlcanceArticulacion;

class ArticulationRegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $scopes = AlcanceArticulacion::orderBy('nombre')->pluck('nombre', 'id');
        return view('articulation.create-articulation', compact('scopes'));
    }

}
