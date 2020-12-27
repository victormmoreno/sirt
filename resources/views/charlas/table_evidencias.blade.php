<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<div class="row">
  <div class="col s12 m12 l12">
    <ul class="collapsible" data-collapsible="accordion">
      <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para ver las evidencias de la Charla Informativa</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="col s12 m12 l12">
              <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="archivosDeUnaCharlaInformartiva">
                <thead>
                  <tr>
                    <th>Archivo</th>
                    <th style="width: 10%">Descargar</th>
                    @if ( \Session::get('login_role') == App\User::IsInfocenter() )
                      <th style="width: 10%">Eliminar</th>
                    @endif
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>
