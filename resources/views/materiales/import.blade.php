@extends('layouts.app')
@section('meta-title', 'Materiales')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                        attach_file
                      </i>
                      Metas
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('material.index')}}">Inicio</a></li>
                      <li class="active">Importar</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="center-align">
                <span class="card-title center-align">Registrar metas</span>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                    <form action="{{route('import.materiales')}}" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <div class="input-field file-field">
                                    <div class="btn">
                                    <span>File</span>
                                    <input type="file" name="nombreArchivo" accept=".xlsx">
                                    </div>
                                    <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="center">
                            <button type="submit" class="waves-effect bg-secondary btn center-aling">
                                <i class="material-icons right">send</i>
                                Importar metas
                            </button>
                            <a href="{{route('material.index')}}" class="waves-effect bg-danger btn center-aling"><i class="material-icons left">backspace</i>Cancelar</a>
                        </div>
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