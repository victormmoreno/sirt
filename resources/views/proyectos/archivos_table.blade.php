<div class="row">
  <div class="col s12 m12 l12">
    <ul class="collapsible" data-collapsible="accordion">
      <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para ver los entregables del proyecto</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="col s12 m12 l12">
              <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="archivosDeUnProyecto">
                <thead>
                  <tr>
                    <th>Archivo</th>
                    <th>Fase</th>
                    <th style="width: 10%">Descargar</th>
                    @if ( \Session::get('login_role') == App\User::IsGestor() )
                      @if ($proyecto->fase->nombre == 'Inicio')
                        <th style="width: 10%">Eliminar</th>
                      @endif
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
