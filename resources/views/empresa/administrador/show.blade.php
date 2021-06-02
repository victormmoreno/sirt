@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('empresa')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Empresas
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <br>
              <center>
                <span class="card-title center-align"><b>Detalle de la empresa</b></span>
              </center>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m3 l3">
                  <ul class="collection with-header">
                    <li class="collection-header"><h5>Opciones</h5></li>
                    <li class="collection-item">
                        <a href="{{ route('empresa.edit', $empresa->id) }}">
                          <div class="card-panel teal lighten-2 black-text center">
                            Cambiar información de la empresa.
                          </div>
                        </a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('empresa.responsable', $empresa->id) }}">
                          <div class="card-panel cyan lighten-2 black-text center">
                            Cambiar responsable de la empresa.
                          </div>
                        </a>
                    </li>
                    <li class="collection-item">
                      <a href="{{ route('empresa.add.sede', $empresa->id) }}">
                        <div class="card-panel blue lighten-2 black-text center">
                          Agregar una nueva sede para el empresa.
                        </div>
                      </a>
                  </li>
                  </ul>
                </div>
                <div class="col s12 m8 l8">
                  @include('empresa.detalle')
                  <center>
                    <a href="{{route('empresa')}}" class="waves-effect red lighten-2 btn center-aling">
                      <i class="material-icons right">backspace</i>Volver
                    </a>
                  </center>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
