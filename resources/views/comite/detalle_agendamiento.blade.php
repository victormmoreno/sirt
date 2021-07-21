<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
@include('comite.historial_cambios')
<div class="divider"></div>
<div class="row no-m-t no-m-b">
    <div class="col s12 m12 l12">
        <div class="mailbox-view">
            <div class="right">
                <small>
                    <b>Fecha de registro: </b>
                    {{optional($comite->created_at)->isoFormat('LL')}}
                </small>
            </div>
            <div class="divider mailbox-divider"></div>
            <div class="mailbox-text">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="center">
                            <span class="mailbox-title">
                                <i class="material-icons">build</i>
                                Información del comité: {{$comite->codigo}}
                                
                            </span>
                        </div>
                        <div class="divider mailbox-divider"></div>
                        <div class="row">
                            <div class="col s12 m2 l2">
                                <div class="row">
                                    <ul class="collection">
                                        <li class="collection-item">
                                            <span class="title cyan-text text-darken-3">
                                                Fecha en la que se realizará el comité
                                            </span>
                                            <p>
                                                {{$comite->fechacomite->isoFormat('YYYY-MM-DD')}}
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s12 m10 l10">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="card-panel blue lighten-5">
                                            <h5 class="center">Ideas que se agendaron para el comité</h5>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th style="width: 30%">Idea de proyecto</th>
                                                        <th style="width: 40%">Dirección</th>
                                                        <th style="width: 10%">Hora</th>
                                                        @if (Session::get('login_role') == App\User::IsInfocenter())
                                                            <th style="width: 20%">Enviar citación</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($comite->ideas as $key => $value)
                                                        <tr>
                                                            <td>{{$value->codigo_idea}} - {{$value->nombre_proyecto}}</td>
                                                            <td>{{$value->pivot->direccion}}</td>
                                                            <td>{{$value->pivot->hora}}</td>
                                                            @if (Session::get('login_role') == App\User::IsInfocenter())
                                                                <td>
                                                                    <a href="{{route('csibt.notificar.agendamiento', [$comite->id, $value->id ,'talentos'])}}">
                                                                        <div class="card-panel blue-grey lighten-3 black-text center">
                                                                            <i class="material-icons left">notifications</i>Enviar citación al talento.
                                                                        </div>
                                                                    </a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m10 l10 offset-m2 offset-l2">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="card-panel green lighten-5">
                                        <h5 class="center">Expertos que se agendaron para el comité</h5>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="1" style="width: 60%">Gestor</th>
                                                    <th colspan="1" style="width: 20%">Desde</th>
                                                    <th colspan="1" style="width: 20%">Hasta</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($comite->gestores->isEmpty())
                                                    <tr>
                                                        <td>No se han encontrado resultados</td>
                                                        <td>No se han encontrado resultados</td>
                                                        <td>No se han encontrado resultados</td>
                                                    </tr>
                                                @else
                                                    @foreach ($comite->gestores as $key => $value2)
                                                        <tr>
                                                            <td colspan="1">{{$value2->user->documento}} - {{$value2->user->nombres}} {{$value2->user->apellidos}}</td>
                                                            <td colspan="1">{{$value2->pivot->hora_inicio}}</td>
                                                            <td colspan="1">{{$value2->pivot->hora_fin}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider mailbox-divider"></div>
            </div>
        </div>
    </div>
</div>
<div id="modalInfoNotificacionComite" class="modal">
    <div class="modal-content">
      <h4>Notificaciones del comité</h4>
      <p>
          Este apartado te permitirá enviar un correo de notificación con información relacionada con el comité.
          <br>
          ¿Cúal opción debo usar?
          <br>
          A continuación podrá ver el funcionamiento de los diferentes botones para enviar la notificación del comité.
          <ul class="collection">
              <li class="collection-item">
                <a href="javascript:void(0)">
                    <div class="card-panel blue-grey lighten-3 black-text center">
                        <i class="material-icons left">notifications</i>Enviar citación al talento.
                    </div>
                </a>
                Este botón enviará una notificación únicamente al talento que inscribió la idea de proyecto.
              </li>
              <li class="collection-item">
                <a href="javascript:void(0)">
                    <div class="card-panel blue-grey lighten-3 black-text center">
                        <i class="material-icons left">notifications</i>Enviar citación a talentos.
                    </div>
                </a>
                Este botón enviará una notificación a todos los talentos.
              </li>
              <li class="collection-item">
                <a href="javascript:void(0)">
                    <div class="card-panel blue-grey lighten-3 black-text center">
                        <i class="material-icons left">notifications</i>Enviar citación a expertos.
                    </div>
                </a>
                Este botón enviará una notificación a todos los expertos.
              </li>
              <li class="collection-item">
                <a href="">
                    <div class="card-panel blue-grey lighten-3 black-text center">
                        <i class="material-icons left">notifications</i>Enviar citación a todos los participantes.
                    </div>
                </a>
                Este botón enviará una notificación del comité a todos los participantes, tanto expertos como talentos.
              </li>
          </ul>
      </p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok.</a>
    </div>
</div>