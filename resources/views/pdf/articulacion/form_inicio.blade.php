<!doctype html>
<html lang="en">
  <head>
    <style>
      .centrar {
        text-align: center;
      }
      footer {
      position: fixed;
      left: 0px;
      bottom: -50px;
      right: 0px;
      height: 40px;
      border-bottom: 2px solid #ddd;
      text-align: right;
    }
    footer .page:after {
      content: counter(page);
    }



    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Formulario de Inicio - {{$articulacion->articulacion_proyecto->actividad->codigo_actividad}}</title>
  </head>
  
  <body>
    <footer>
        GD-F-007 V01
    </footer>
    <table class="table-bordered table-sm">
      <thead>
        <tr>
          <th colspan="1">
            <center>
              <img src="{{asset('img/web.png')}}">
            </center>
          </th>
          <th colspan="5" class="centrar">ACTA No.</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="centrar" scope="row" colspan="6"><b>TÍTULO DE LA ARTICULACIÓN: {{$articulacion->articulacion_proyecto->actividad->nombre}}</b></td>
        </tr>
        <tr>
          <td colspan="1" scope="row">Nodo: <b>{{$articulacion->articulacion_proyecto->actividad->nodo->entidad->nombre}}</b></td>
          <td colspan="2">Fecha: <b>{{$articulacion->articulacion_proyecto->actividad->fecha_inicio->isoFormat('YYYY-MM-DD')}}</b></td>
          <td colspan="3">Código de la Articulación: <b>{{$articulacion->articulacion_proyecto->actividad->codigo_actividad}}</b></td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">DATOS DEL GRUPO DE INVESTIGACIÓN</th>
        </tr>
        <tr>
          <td colspan="3">Código del Grupo de Investigación: <b>{{$articulacion->articulacion_proyecto->entidad->grupoinvestigacion->codigo_grupo}}</b></td>
          <td colspan="3">Nombre del Grupo de Investigación: <b>{{$articulacion->articulacion_proyecto->entidad->nombre}}</b></td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">TALENTOS QUE PARTICIPAN EN LA ARTICULACIÓN</th>
        </tr>
        <tr>
          {{-- <td colspan="1"></td> --}}
          <td colspan="6">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th style="width: 40%">Talento Interlocutor</th>
                  <th style="width: 60%">Talento</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($articulacion->articulacion_proyecto->talentos as $key => $value)
                <tr>
                  <td>
                    {{$value->pivot->talento_lider == 1 ? 'SI' : 'NO'}}
                  </td>
                  <td>{{$value->user->documento}} - {{$value->user->nombres}} {{$value->user->apellidos}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </td>
          {{-- <td colspan="1"></td> --}}
        </tr>
        <tr>
          <th class="centrar" colspan="6">ACUERDOS DE COAUTORÍA Y ALCANCE DE LA ARTICULACIÓN</th>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>ACUERDOS DE COAUTORÍA</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$articulacion->acuerdos}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>ALCANCE DE LA ARTICULACIÓN</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$articulacion->alcance_articulacion}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">PRODUCTOS A ALCANZAR</th>
        </tr>
        <tr>
          <td colspan="6">
            @if ($articulacion->productos->count() > 0)
            <ul>
              @foreach ($articulacion->productos as $key => $value)
              <li>
                {{$value->nombre}}
              </li>
              @endforeach
            </ul>
            @else
            <p>
              No se encontraron productos a alcanzar.
            </p>
            @endif
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">ASISTENTES</th>
        </tr>
        <tr>
          <th class="centrar" colspan="2"><small><b>NOMBRE</b></small></th>
          <th class="centrar" colspan="2"><small><b>CARGO</b></small></th>
          <th class="centrar" colspan="2"><small><b>FIRMA</b></small></th>
        </tr>
        <tr>
          <td class="centrar" colspan="2"><small>{{$articulacion->articulacion_proyecto->actividad->gestor->user->nombres}} {{$articulacion->articulacion_proyecto->actividad->gestor->user->apellidos}}</small></td>
          <td class="centrar" colspan="2"><small>Gestor</small></td>
          <td class="centrar" colspan="2"></td>
        </tr>
        @foreach ($articulacion->articulacion_proyecto->talentos as $value)
        <tr>
            <td class="centrar" colspan="2"><small>{{$value->user->nombres}} {{$value->user->apellidos}}</small></td>
            @if ($value->pivot->talento_lider == 1)
            <td class="centrar" colspan="2"><small>Talento Interlocutor</small></td>
            @else
            <td class="centrar" colspan="2"><small>Talento</small></td>
            @endif
          <td class="centrar" colspan="2"></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>