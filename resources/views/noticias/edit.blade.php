@extends('layouts.app')

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
                                        <span class="card-title center-align">Modificar Noticia</span>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="row">
                                @if (count($errors)>0)
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <span style="color: red;">
                                        <li>{{ $error }}</li>
                                        </span>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <br><br>

                                <form action= "{{ url('/noticias/'.$noticias->id) }}" method="post" enctype="multipart/form-data">

                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}

                                    <div class="form-group">
                                        <label class="control-label" for="Titulo">{{'Titulo'}}</label>
                                        <input class="form-control {{ $errors->has('Titulo')?'is-invalid':'' }}" type="text" name="Titulo" id="Titulo" placeholder="Agregar título" value="{{ $noticias->Titulo }}">
                                        <span style="color: red;">{!! $errors->first('Titulo','<div class="invalid-feedback">:message</div>') !!}</span>
                                    </div>

                                    <br><br>
                                    <label for="Imagen">{{'Imagen Actual'}}</label>
                                    <br><br>
                                    <img src="{{ asset('storage').'/'.$noticias->Imagen }}" alt="" class="img-thumbnail img-fluid" width="300">
                                    <br><br>

                                    <div class="form-group">
                                        <input class="form-control {{ $errors->has('Imagen')?'is-invalid':'' }}" type="file" name="Imagen" id="Imagen" value="" accept="image/*">
                                        <span style="color: red;">{!! $errors->first('Imagen','<div class="invalid-feedback">:message</div>') !!}</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="Descripcion">{{'Descripción'}}</label><br>
                                        <textarea  class="form-control {{ $errors->has('Descripcion')?'is-invalid':'' }}" name="Descripcion" id="Descripcion" placeholder="Agregar descripción" cols="40" rows="10" >{{ $noticias->Descripcion }}</textarea>
                                        <span style="color: red;">{!! $errors->first('Descripcion','<div class="invalid-feedback">:message</div>') !!}</span>
                                    </div>

                                    <input class="btn btn-success" type="submit" value="Modificar">
                                    <a class="btn btn-primary" href="{{ url('noticias') }}">Regresar</a>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

</main>


@endsection

