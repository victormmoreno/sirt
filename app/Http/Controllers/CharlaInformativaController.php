<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CharlaInformativaFormRequest;
use Illuminate\Support\Facades\{Session};
use App\{User, Models\Nodo};
use App\Repositories\Repository\{CharlaInformativaRepository};
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\{ArrayHelper};

class CharlaInformativaController extends Controller
{

    /**
     * Objeto de la clase CharlaInformativaRepository
     * @var object
     */
    private $charlaInformativaRepository;

    public function __construct(CharlaInformativaRepository $charlaInformativaRepository)
    {
        $this->charlaInformativaRepository = $charlaInformativaRepository;
    }

    /**
     *  Modifica las evidencias de una charla informativa
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateEvidencias(Request $request, $id)
    {
        $update = $this->charlaInformativaRepository->updateEvidenciasRepository($request, $id);
        if ($update) {
        Alert::success('Modificación Exitosa!', 'Las evidencias de la Charla Informartiva se han modificado con éxito')->showConfirmButton('Ok!', '#3085d6');
        return redirect('charla');
        } else {
        Alert::error('Modificación Errónea!', 'Las evidencias de la Charla Informativa no se han modificado')->showConfirmButton('Ok!', '#3085d6');
        return back()->withInput();
        }
    }

    /**
     * Consulta el detalle de una charla informativa
     * @param int $id Id de la charla informativa
     * @return Response
     * @author Victor Manuel Moreno Vega
     */
    public function detallesDeUnaCharlaInformativa($id)
    {
        if (request()->ajax()) {
        $charla = $this->charlaInformativaRepository->consultarInformacionDeUnaCharlaInformativaRepository($id)->toArray();
        $charla = ArrayHelper::validarDatoNullDeUnArray($charla);
        return response()->json([
            'charla' => $charla
        ]);
        }
    }

    /**
     * Vista para subir las evidencias de una charla informativa
     * @param int $id Id de la charla informativa
     * @return Response
     */
    public function evidencias($id)
    {
        return view('charlas.evidencia', [
            'charla' => $this->charlaInformativaRepository->consultarInformacionDeUnaCharlaInformativaRepository($id)
        ]);
    }

    /**
     * Pinta las datatables de las consulta de charlas informativas
     * @param Collection $datos Datos sobre el cual se mostrarán las charlas informativas
     * @return Response
     */
    private function datatableCharlasInformativas($datos)
    {
        return datatables()->of($datos)
        ->addColumn('details', function ($data) {
        $details = '
        <a class="btn light-blue m-b-xs" onclick="consultarDetallesDeUnaCharlaInformativa(' . $data->id . ')">
            <i class="material-icons">info</i>
        </a>
        ';
        return $details;
        })->addColumn('edit', function ($data) {
        if ( $data->estado == 'Inactiva') {
            $edit = '<a class="btn m-b-xs" disabled><i class="material-icons">edit</i></a>';
        } else {
            $edit = '<a class="btn m-b-xs" href='.route('charla.edit', $data->id).'><i class="material-icons">edit</i></a>';
        }
        return $edit;
        })->addColumn('evidencias', function ($data) {
        $evidencias = '
        <a class="btn blue-grey m-b-xs" href='. route('charla.evidencias', $data->id) .'>
            <i class="material-icons">library_books</i>
        </a>
        ';
        return $evidencias;
        })->addColumn('delete', function ($data) {
        $delete = '
        <a class="btn red lighten-3 m-b-xs" onclick="inhabilitarCharlaInformativa('.$data->id.', event)">
        <i class="material-icons">delete_sweep</i>
        </a>
        ';
        return $delete;
        })->rawColumns(['details', 'edit', 'delete', 'evidencias'])->make(true);
    }

    /**
     * Consulta las charlas informativas de un nodo
     * @param int $id Id del nodo
     * @return Response
     */
    public function datatableCharlasInformativosDeUnNodo($id)
    {
        $nodo_id = $this->getNodoForIndex($id);
        $charlas = $this->charlaInformativaRepository->consultarCharlasInformativasDeUnNodoRepository($nodo_id);
        return $this->datatableCharlasInformativas($charlas);
    }

    public function getNodoForIndex($id)
    {
        if (session()->get('login_role') == User::IsInfocenter()) {
            return auth()->user()->infocenter->nodo_id;
          } 
          if (session()->get('login_role') == User::IsArticulador()) {
            return auth()->user()->articulador->nodo_id;
          }
          if (session()->get('login_role') == User::IsDinamizador()) {
            return auth()->user()->dinamizador->nodo_id;
          }
          if (session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsArticulador()) {
            if ($id == 0) {
                return Nodo::SelectNodo()->get()->first()->id;
            } else {
                return $id;
            }
          }
    }

    public function index()
    {
        return view('charlas.index', [
            'nodos' => Nodo::SelectNodo()->get()
        ]);
    }
    /**
     * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('charlas.create', [
            'nodos' => Nodo::SelectNodo()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(CharlaInformativaFormRequest $request)
    {
        $store = $this->charlaInformativaRepository->storeCharlaInformativaRepository($request);
        if ($store) {
        Alert::success('Registro Exitoso!', 'La Charla Informativa se ha registrado satisfactoriamente')->showConfirmButton('Ok!', '#3085d6');
        return redirect('charla');
        } else {
        Alert::error('Registro Erróneo!', 'La Charla Informativa no se ha registrado')->showConfirmButton('Ok!', '#3085d6');
        return back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        return view('charlas.edit', [
        'charla' => $this->charlaInformativaRepository->consultarInformacionDeUnaCharlaInformativaRepository($id),
        'nodos' => Nodo::SelectNodo()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(CharlaInformativaFormRequest $request, $id)
    {
        $update = $this->charlaInformativaRepository->updateCharlaInformativaRepository($request, $id);
        if ($update) {
        Alert::success('Modificación Exitosa!', 'La Charla Informativa se ha modificado satisfactoriamente')->showConfirmButton('Ok!', '#3085d6');
        return redirect('charla');
        } else {
        Alert::error('Modificación Errónea!', 'La Charla Informativa no se ha modificado')->showConfirmButton('Ok!', '#3085d6');
        return back()->withInput();
        }
    }

}
