<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticulationShowController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        return view('articulation.show');
    }

}
