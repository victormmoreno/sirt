<?php

namespace App\Http\Controllers;

use App\Models\{Tag, Proyecto, Idea};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repositories\Repository\TagRepository;

class TagController extends Controller
{

    private $types = [
        Proyecto::class,
        // Idea::class
    ];

    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Pinta la datatable para datos de las etiquetas
     * @param object $ingresos Datos de los cuales se mostrarán la datatable para las etiquetas
     * @return Response
     */
    private function datatableTags($tags)
    {
        return datatables()->of($tags)
        ->addColumn('edit', function ($data) {
        $edit = '<a class="btn bg-warning m-b-xs" href='.route('tag.edit', $data->id).'><i class="material-icons">edit</i></a>';
        return $edit;
        })->addColumn('delete', function ($data) {
            if ($data->state == $data->IsActive()) {
                return '<a class="btn bg-danger lighten-3 m-b-xs" href='.route('tag.state', [$data, 0]).'><i class="material-icons">autorenew</i></a>';
            }
            return '<a class="btn bg-danger lighten-3 m-b-xs" href='.route('tag.state', [$data, 1]).'><i class="material-icons">autorenew</i></a>';
        // return $edit;
        })->editColumn('type', function ($data) {
            return class_basename($data->type);
        })->editColumn('state', function ($data) {
            return $data->state == $data->IsActive() ? 'Activa' : 'Inactiva';
        })->editColumn('name', function ($data) {
            return '<b>'.$data->name . '</b>: ' . $data->description;
        })
        ->rawColumns(['edit', 'delete', 'name'])->make(true);
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update_state($tag, $state)
    {
        if(!request()->user()->can('update', Tag::class)) {
            alert('No autorizado', 'No tienes permisos para cambiar el estado de esta etiqueta!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $result = $this->tagRepository->update_state($tag, $state);
        alert($result['title'], $result['msg'], $result['type']);
        return back();
    }

    /**
     * Lista de etiquetas
     *
     * @param string $type
     * @return datatables
     * @author dum
     **/
    public function tagsList(Request $request)
    {
        // dd($request);
        $tags = Tag::TagsByType($request->type)->get();
        return $this->datatableTags($tags);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index', ['types' => $this->types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!request()->user()->can('create', Tag::class)) {
            alert('No autorizado', 'No tienes permisos para registrar caracterizaciones!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        // dd($this->types);
        // dd(class_basename(Proyecto::class));
        return view('tags.create', [
            'types' => $this->types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!request()->user()->can('create', Tag::class)) {
            alert('No autorizado', 'No puedes registrar caracterizaciones', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $result = $this->tagRepository->store($request);
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit($tag)
    {
        if(!request()->user()->can('update', Tag::class)) {
            alert('No autorizado', 'No tienes permisos para cambiar la información de esta etiqueta!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('tags.edit', [
            'tag' => Tag::find($tag),
            'types' => $this->types
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tag)
    {
        if(!request()->user()->can('update', Tag::class)) {
            alert('No autorizado', 'No tienes permisos para cambiar la información de esta etiqueta!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        // dd($tag);
        $result = $this->tagRepository->update($request, Tag::find($tag));
        return response()->json($result);
    }

}
