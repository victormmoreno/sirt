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

    <title>Formulario de Cierre - {{$articulacion->articulacion_proyecto->actividad->codigo_actividad}}</title>
  </head>
  
  <body>
    <footer>
        GD-F-007 V01
    </footer>
    <table class="table-bordered table-sm" style="witdh: 100%">
      <thead>
        <tr>
          <th colspan="1">
            <center>
              <img src="{{asset('img/web.png')}}">
            </center>
          </th>
          <th colspan="5" class="centrar">ACTA No. {{ substr($articulacion->articulacion_proyecto->actividad->codigo_actividad, -4) . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="centrar" scope="row" colspan="6"><b>TÍTULO DE LA ARTICULACIÓN: {{$articulacion->articulacion_proyecto->actividad->nombre}}</b></td>
        </tr>
        <tr>
          <td colspan="1" scope="row">Tecnoparque Nodo: <b>{{$articulacion->articulacion_proyecto->actividad->nodo->entidad->nombre}}</b></td>
          <td colspan="2">Fecha: <b>{{Carbon\Carbon::now()->isoFormat('YYYY-MM-DD')}}</b></td>
          <td colspan="3">Código de la Articulación: <b>{{$articulacion->articulacion_proyecto->actividad->codigo_actividad}}</b></td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">CONCLUSIONES Y SIGUIENTES INVESTIGACIONES</th>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>CONCLUSIONES</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$articulacion->articulacion_proyecto->actividad->conclusiones}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>SIGUIENTES INVESTIGACIONES O PROYECTOS DE LA ARTICULACIÓN</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$articulacion->siguientes_investigaciones}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">PRODUCTOS ALCANZADOS</th>
        </tr>
        <tr>
          <td colspan="6">
            @if ($articulacion->productos->count() > 0)
            <ul>
              @foreach ($articulacion->productos as $key => $value)
              <li>
                Producto: {{$value->nombre}}
                <br>
                ¿Se cumplió?: {{$value->pivot->logrado == 1 ? 'SI' : 'NO'}} 
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
        <tr>
          <td class="centrar" colspan="2"><small>{{$articulacion->articulacion_proyecto->talentos()->wherePivot('talento_lider', '=', 1)->first()->user->nombres}} {{$articulacion->articulacion_proyecto->talentos()->wherePivot('talento_lider', '=', 1)->first()->user->apellidos}}</small></td>
          <td class="centrar" colspan="2"><small>Talento Interlocutor</small></td>
          <td class="centrar" colspan="2"></td>
        </tr>
      </tbody>
    </table>
  </body>
</html>