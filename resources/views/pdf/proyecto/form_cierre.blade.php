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

    <title>Formulario de Cierre - {{$proyecto->articulacion_proyecto->actividad->codigo_actividad}}</title>
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
          <td colspan="2">Fecha: <b>{{Carbon\Carbon::now()->isoFormat('YYYY-MM-DD')}}</b></td>
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
          <td colspan="2">
            @if ($proyecto->trl_obtenido == 0)
            <p>TRL obtenido: <b>TRL 6</b></p>
            @elseif($proyecto->trl_obtenido == 1)
            <p>TRL obtenido: <b>TRL 7</b></p>
            @else
            <p>TRL obtenido: <b>TRL 8</span></p>
            @endif
          </td>
          <td colspan="2">
            ¿Dirigido al área de emprendimiento SENA?: <b>{{$proyecto->diri_ar_emp == 0 ? 'NO' : 'SI'}}</b>
          </td>
          <td colspan="2">
            Costo aproximado del proyecto: <b>$ {{$costo->getData()->costosTotales}}</b></span>
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
          <th class="centrar" colspan="6">OBJETIVOS CUMPLIDOS DEL PROYECTO Y CONCLUSIONES</th>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>OBJETIVOS ESPECÍFICOS CUMPLIDOS</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            <ol>
              <li>
                {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo }}
                <br>
                ¿Se cumplió?
                <br>
                <b>{{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->cumplido == 1 ? 'SI' : 'NO' }}</b>
              </li>
              <li>
                {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo }}
                <br>
                ¿Se cumplió?
                <br>
                <b>{{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->cumplido == 1 ? 'SI' : 'NO' }}</b>
              </li>
              <li>
                {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo }}
                <br>
                ¿Se cumplió?
                <br>
                <b>{{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->cumplido == 1 ? 'SI' : 'NO' }}</b>
              </li>
              <li>
                {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo }}
                <br>
                ¿Se cumplió?
                <br>
                <b>{{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->cumplido == 1 ? 'SI' : 'NO' }}</b>
              </li>
            </ol>
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>CONCLUSIONES Y SIGUIENTE PASO DEL PROYECTO</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$proyecto->articulacion_proyecto->actividad->conclusiones}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">EVIDENCIAS TRL</th>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>EVIDENCIAS DE PROTOTIPO DEL PRODUCTO</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$proyecto->trl_prototipo}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>EVIDENCIAS DE PRUEBAS DOCUMENTADAS</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$proyecto->trl_pruebas}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>EVIDENCIAS DE MODELO DE NEGOCIO</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$proyecto->trl_modelo}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6"><small><b>EVIDENCIAS DE NORMATIVIDAD</b></small></th>
        </tr>
        <tr>
          <td colspan="6">
            {{$proyecto->trl_normatividad}}
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
          <td class="centrar" colspan="2"><small>{{$proyecto->articulacion_proyecto->actividad->gestor->user->nombres}} {{$proyecto->articulacion_proyecto->actividad->gestor->user->apellidos}}</small></td>
          <td class="centrar" colspan="2"><small>Gestor</small></td>
          <td class="centrar" colspan="2"></td>
        </tr>
        <tr>
          <td class="centrar" colspan="2"><small>{{$proyecto->articulacion_proyecto->talentos()->wherePivot('talento_lider', '=', 1)->first()->user->nombres}} {{$proyecto->articulacion_proyecto->talentos()->wherePivot('talento_lider', '=', 1)->first()->user->apellidos}}</small></td>
          <td class="centrar" colspan="2"><small>Talento Interlocutor</small></td>
          <td class="centrar" colspan="2"></td>
        </tr>
      </tbody>
    </table>
  </body>
</html>