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

    <title>Acta de Inicio</title>
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
          <th colspan="5" class="centrar">ACTA No. {{ substr($proyecto->articulacion_proyecto->actividad->codigo_actividad, -4) . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="centrar" scope="row" colspan="6"><b>TÍTULO DE PROYECTO: {{$proyecto->articulacion_proyecto->actividad->nombre}}</b></td>
        </tr>
        <tr>
          <td colspan="1" scope="row">Nodo: <b>{{$proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre}}</b></td>
          <td colspan="2">Fecha: <b>{{$proyecto->articulacion_proyecto->actividad->fecha_inicio->isoFormat('YYYY-MM-DD')}}</b></td>
          <td colspan="3">Código del Proyecto: <b>{{$proyecto->articulacion_proyecto->actividad->codigo_actividad}}</b></td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">DATOS DEL PROYECTO</th>
        </tr>
        <tr>
          <td colspan="3">Código de la Idea de Proyecto: <b>{{$proyecto->idea->codigo_idea}}</b></td>
          <td colspan="3">Nombre de la Idea de Proyecto: <b>{{$proyecto->idea->nombre_proyecto}}</b></td>
        </tr>
        <tr>
          <td colspan="3">
            Área de conocimiento: <b>{{$proyecto->areaconocimiento->nombre}}</b>
            @if ($proyecto->areaconocimiento->nombre == 'Otro')
            <br>
            {{$proyecto->otro_areaconocimiento}}
            @endif
          </td>
          <td colspan="3">Sublínea: <b>{{$proyecto->sublinea->nombre}}</b></td>
        </tr>
        <tr>
          <td colspan="2">TRL que se pretende realizar: <b>{{$proyecto->trl_esperado == 0 ? 'TRL6' : 'TRL 7 - TRL 8'}}</b></td>
          <td colspan="2">¿Recibido a través de fábrica de productividad?: <b>{{$proyecto->fabrica_productividad == 0 ? 'NO' : 'SI'}}</b></td>
          <td colspan="2">¿Recibido a través del área de emprendimiento SENA?: <b>{{$proyecto->reci_ar_emp == 0 ? 'NO' : 'SI'}}</b></td>
        </tr>
        <tr  style="page-break-inside:avoid;">
          <td colspan="2">
            ¿El proyecto pertenece a la economía naranja?: <b>{{$proyecto->economia_naranja == 0 ? 'NO' : 'SI'}}</b>
            @if ($proyecto->economia_naranja == 1)
            <br>
            Tipo de economía naranja: <b>{{$proyecto->tipo_economianaranja}}</b>
            @endif
          </td>
          <td colspan="2">
            ¿El proyecto está dirigido a personas en condición de discapacidad?: <b>{{$proyecto->dirigido_discapacitados == 0 ? 'NO' : 'SI'}}</b>
            @if ($proyecto->dirigido_discapacitados == 1)
            <br>
            Tipo de discapacidad: <b>{{$proyecto->tipo_discapacitados}}</b></p>
            @endif
          </td>
          <td colspan="2">
            Articulado con CT+i: <b>{{$proyecto->art_cti == 0 ? 'NO' : 'SI'}}</b>
            @if ($proyecto->art_cti == 1)
            <br>
            Nombre del Actor CT+i: <b>{{$proyecto->nom_act_cti}}</b>
            @endif
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">TALENTOS QUE PARTICIPAN EN EL PROYECTO</th>
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
                @foreach ($proyecto->articulacion_proyecto->talentos as $key => $value)
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
          <th class="centrar" colspan="6">OBJETIVOS DEL PROYECTO Y ALCANCE</th>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>OBJETIVO GENERAL</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$proyecto->articulacion_proyecto->actividad->objetivo_general}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>OBJETIVOS ESPECÍFICOS</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            <ol>
              <li>{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo}}</li>
              <li>{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo}}</li>
              <li>{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo}}</li>
              <li>{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo}}</li>
            </ol>
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>ALCANCE DEL PROYECTO</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$proyecto->alcance_proyecto}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">DATOS DE LA PROPIEDAD INTELECTUAL</th>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>PERSONAS (TALENTOS)</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            @if ($proyecto->users_propietarios->count() > 0)
            <ul>
              @foreach ($proyecto->users_propietarios as $key => $value)
              <li>
                {{$value->documento}} - {{$value->nombres}} {{$value->apellidos}}
              </li>
              @endforeach
            </ul>
            @else
            <p>
              No se encontraron personas dueñas de la propiedad intelectual.
            </p>
            @endif
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>EMPRESAS</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            @if ($proyecto->sedes->count() > 0)
            <ul>
              @foreach ($proyecto->sedes as $key => $value)
              <li>
                {{$value->empresa->nit}} - {{ $value->empresa->nombre }} ({{ $value->nombre_sede }})
              </li>
              @endforeach
            </ul>
            @else
            <p>
              No se encontraron empresas dueñas de la propiedad intelectual.
            </p>
            @endif
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>GRUPOS DE INVESTIGACIÓN</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            @if ($proyecto->gruposinvestigacion->count() > 0)
            <ul>
              @foreach ($proyecto->gruposinvestigacion as $key => $value)
              <li>
                {{$value->codigo_grupo}} - {{ $value->entidad->nombre }}
              </li>
              @endforeach
            </ul>
            @else
            <p>
              No se encontraron grupos de investigación dueños de la propiedad intelectual.
            </p>
            @endif
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>