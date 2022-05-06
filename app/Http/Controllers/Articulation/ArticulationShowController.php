<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articulation;

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
        $articulations = Articulation::with(['accompaniment'])->withCount('users')->where('accompaniment_id',$id)->paginate(6);

        // return $articulations;

        return view('articulation.show', compact('articulations'));
    }

}
