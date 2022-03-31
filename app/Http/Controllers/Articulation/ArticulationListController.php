<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticulationListController extends Controller
{
    /**
     * method to show the list of accompaniments (index) with filters
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @author julicode
     */
    public function index(Request $request)
    {
        return view('articulation.index-accompaniment');
    }

}
