<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
use App\Imports\MigracionProyectosImport;
use App\Models\Nodo;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Articulacion;
use App\Models\ArticulacionPbt;
use App\Models\ArticulationStage;
use App\Models\Proyecto;
use App\User;
use App\Models\Sede;
use Illuminate\Support\Facades\Storage;
use Artisan;

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

        $validator = Validator::make($request->all(), [
            'nombreArchivo' => ['required'],
            'txtnodo_id' => ['required']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        session()->put('errorMigracion', null);
        Excel::import(new MigracionProyectosImport($request->txtnodo_id), request()->file('nombreArchivo'));
        if (Session::get('errorMigracion') == null) {
            alert()->success('Migración Exitosa!', 'La información se ha migrado exitósamente!')->showConfirmButton('Ok', '#3085d6');
        } else {
            alert()->error('Migración Errónea!', Session::get('errorMigracion'))->showConfirmButton('Ok', '#3085d6');
        }
        session()->put('errorMigracion', null);
        return back();
    }



    public function migrateArticulations()
    {
        // Artisan::call('db:seed --class=ArticulationMigrationSeeder');
        // Artisan::output();
        try{
            $seeder = new \ArticulationMigrationSeeder();
            $seeder->run();
        }catch(\Exception $e){
            echo $e->getMessage();
        }

    }
}
