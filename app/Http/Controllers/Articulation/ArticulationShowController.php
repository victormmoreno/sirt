<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articulation;
use App\Models\Accompaniment;

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


        $accompaniment = Accompaniment::with(['articulations', 'projects'])->findOrfail($id);
        $articulations = Articulation::with(['phase'])
                        ->where('accompaniment_id',$id)
                        ->latest('id')
                        ->paginate(6);



        // return $accompaniment;

        return view('articulation.show', compact('accompaniment', 'articulations'));
    }

}
