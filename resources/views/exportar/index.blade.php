@extends('layouts.app')
@section('meta-title', 'Exportar')
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
                      Exportar
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Exportar</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="center-align">
                <span class="card-title center-align">Exportar de base de datos</span>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                    <ul class="collapsible">
                        <li>
                          <div class="collapsible-header"><i class="material-icons">filter_drama</i>Usuarios</div>
                          <div class="collapsible-body">
                              <div class="row">
                                <p>
                                    Esta opción descargará un archivo json con los datos para el documento de usuarios.
                                    <br>
                                    <a onclick="generarJsonUsuarios();" class="btn"><i class="material-icons right">file_download</i>Descargar</a>

                                </p>
                              </div>
                          </div>
                        </li>
                        <li>
                          <div class="collapsible-header"><i class="material-icons">place</i>Second</div>
                          <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
                        </li>
                        <li>
                          <div class="collapsible-header"><i class="material-icons">whatshot</i>Third</div>
                          <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
                        </li>
                      </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
@push('script')
    <script>
        function generarJsonUsuarios() {
            location.href = "{{route('exportar.json.user')}}";
        }
    </script>
@endpush