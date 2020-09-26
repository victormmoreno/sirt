@extends('layouts.app')
@section('meta-title', 'Migraciones')
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
                      Migraciones
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Migraciones</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="center-align">
                <span class="card-title center-align">Migraciones de base de datos</span>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                    <form action="{{route('migracion.proyectos.store')}}" method="POST" enctype="multipart/form-data">
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
                          <div class="input-field col s12 m6 l6">
                            <select class="js-states select2 browser-default" name="txtnodo_id" id="txtnodo_id" style="width: 100%">
                              @foreach($nodos as $nodo)
                                <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                              @endforeach
                            </select>
                            <label for="txtnodo_id" class="active">Seleccione el Nodo</label>
                          </div>
                        </div>
                        <center>
                          <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
                              <i class="material-icons right">done</i>
                              Migrar
                          </button>
                        </center>
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