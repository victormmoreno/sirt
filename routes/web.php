<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    // $departaments = App\Models\Departamento::with(['cities'])->get();
    // $departaments = App\Models\Departamento::first();
    // dd($departaments->cities);

    // $city = App\Models\Ciudad::first();
    // dd($city->departament);
    // 
    
    $regionals = App\Models\CentroFormacion::get()->last();
    dd($regionals->regional);

    // $tiposdocumentos = App\Models\TipoDocumento::first();
    // $tiposdocumentos->created_at->year //año
    // $tiposdocumentos->created_at->month //mes
    // $tiposdocumentos->created_at->day //dia
    // $tiposdocumentos->created_at->addDays(2) //añadir dias
    // $tiposdocumentos->created_at->subDays(2) //restar dias
    // $tiposdocumentos->created_at->addWeeks(2) //sumar semanas
    // $tiposdocumentos->created_at->addMonths(2) //sumar meses
    // $tiposdocumentos->created_at->yesterday() //dia de ayer
    // $tiposdocumentos->created_at->tomorrow() //dia de mañana
    // $tiposdocumentos->created_at->dayOfWeek //dia de la semana
    // $tiposdocumentos->created_at->diffForHumans() //leible para humanos
    // $tiposdocumentos->created_at->startOfMonth() //dia que inicio el mes
    // $tiposdocumentos->created_at->endOfMonth() //dia que finalizo el mes
    // $tiposdocumentos->created_at->toDateString() //fecha sting
    // $tiposdocumentos->created_at->toFormattedDateString() //fecha sting

    // dd($tiposdocumentos->created_at->subDays(3)->isoFormat('dddd MMM  YYYY'));
    // dd($tiposdocumentos->created_at->subDays(3)->diffForHumans());

    return view('spa');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
