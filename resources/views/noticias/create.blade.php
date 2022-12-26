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
                            <span class="card-title center-align">Agregar Noticia</span>
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

                            <form action="{{ url('/noticias') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="Titulo" class="control-label">{{'Titulo'}}</label>
                                    <input type="text" name="Titulo" id="Titulo" class="form-control {{ $errors->has('Titulo')?'is-invalid':'' }}" placeholder="Agregar título" value="{{ old('Titulo') }}">
                                    <span style="color: red;">{!! $errors->first('Titulo','<div class="invalid-feedback">:message</div>') !!}</span>
                                </div>

                                <br><br>

                                <div class="form-group">
                                    <label for="Imagen" class="control-label">{{'Imagen'}}</label>
                                    <input class="form-control {{ $errors->has('Imagen')?'is-invalid':'' }}" type="file" name="Imagen" id="Imagen" value="" accept="image/*">
                                    <span style="color: red;">{!! $errors->first('Imagen','<div class="invalid-feedback">:message</div>') !!}</span>
                                </div>

                                <br><br>

                                <div class="form-group">
                                    <label for="Descripcion" class="control-label">{{'Descripción'}}</label><br><br>
                                    <textarea name="Descripcion" id="Descripcion" placeholder="Agregar descripción" cols="10" rows="10" class="form-control {{ $errors->has('Descripcion')?'is-invalid':'' }}">{{ old('Descripcion') }}</textarea>
                                    <span style="color: red;">{!! $errors->first('Descripcion','<div class="invalid-feedback">:message</div>') !!}</span>
                                </div>

                                <br><br>

                                <input class="btn btn-success" type="submit" value="Agregar">
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
