@extends('layouts.app')
@section('meta-title', 'Noticias')
@section('meta-content', 'Noticias')
@section('meta-keywords', 'Noticias')

@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">

<main class="mn-inner inner-active-sidebar">
    <div class="content">
    <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
        <h5><i class="left material-icons">local_library</i>Noticias</h5>
        <div class="card">
            <div class="card-content">
            <div class="row">
                <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s12 m10 l10">
                    <div class="center-align">
                        <span class="card-title center-align">Noticias de Tecnoparque</span>
                    </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <br>
                    @if (Session::has('Mensaje'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('Mensaje') }}
                    </div>
                    @endif
                    <br>
                    <a href="{{ url('noticias/create') }}" class="btn btn-success">Agregar Noticia</a>

                    <br><br>

                    <table class="table table-light table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                                <th>Imagen</th>
                                <th>Descripción</th>
                                <th colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($noticias as $noticia)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $noticia->Titulo }}</td>
                                <td>
                                    <img src="{{ asset('storage').'/'.$noticia->Imagen }}" class="img-thumbnail img-fluid" alt=""width="200">
                                </td>
                                <td>{{ $noticia->Descripcion }}</td>
                                <td>
                                    <a class="btn btn-warning" href="{{ url('/noticias/'.$noticia->id.'/edit') }}">Modificar</a>
                                </td>
                                <td>
                                    <form action="{{ url('/noticias/'.$noticia->id) }}" method="post" style="display:inline">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('¿Borrar?');">Borrar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $noticias->links() }}

                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>

</main>




@endsection
