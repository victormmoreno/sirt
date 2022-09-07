<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticulationStage;
use App\Models\Entidad;
use App\Models\Articulation;
use App\User;
use Illuminate\Support\Str;
use App\Exports\Articulation\articulationStageExport;

class ArticulationListController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articulation = Articulation::findOrfail($id);
        return view('articulation.show-articulation', compact('articulation'));
    }

}
