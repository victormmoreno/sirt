@extends('layouts.app')
@section('meta-title', 'Equipos')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
          <h5 class="left left-align primary-text">
              <i class="material-icons left">
                account_balance_wallet
              </i>
              Equipos
          </h5>
          <div class="right rigth-align show-on-large hide-on-med-and-down">
              <ol class="breadcrumbs">
                  <li><a href="{{route('equipo.index')}}">Inicio</a></li>
                  <li class="active">Importar</li>
              </ol>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="center-align">
                <span class="card-title center-align">Importar equipos</span>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                    <form action="{{route('import.equipos')}}" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="input-field file-field">
                                    <div class="btn">
                                      <span>File</span>
                                      <input type="file" name="nombreArchivo" accept=".xlsx" required>
                                    </div>
                                    <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="center">
                          @can('import', App\Models\Equipo::class)
                              <a href="{{route('download.equipos')}}" class="waves-effect waves-grey bg-secondary-lighten white-text btn">Descargar formato de equipos</a>
                          @endcan
                          <button type="submit" class="waves-effect bg-secondary btn center-aling">
                            <i class="material-icons right">send</i>
                            Importar equipos
                          </button>
                            <a href="{{route('equipo.index')}}" class="waves-effect bg-danger btn center-aling"><i class="material-icons left">backspace</i>Cancelar</a>
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