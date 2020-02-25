<!doctype html>
<html lang="en">
  <head>
    <style>
      .centrar {
        text-align: center;
      }
        /* table {
    border-collapse: collapse;
  }
  
  table, th, td {
    border: 1px solid black;
  } */
    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <table class="table table-bordered table-sm">
      <thead>
        <tr>
          <th scope="row">img</th>
          <th colspan="5" class="centrar">ACTA No.</th>
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
        <tr>
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
            Tipo de discapacidad: <b>{{$proyecto->nom_act_cti}}</b>
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
          <td colspan="6">
            <p>
              <b>Objetivo general del proyecto.</b>
            </p>
            <p>
              {{$proyecto->articulacion_proyecto->actividad->objetivo_general}}
            </p>
            <p>
              <b>Objetivos específicos del proyecto.</b>
            </p>
            <ol>
              <li>{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo}}</li>
              <li>{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo}}</li>
              <li>{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo}}</li>
              <li>{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo}}</li>
            </ol>
            <p>
              <b>Alcance del proyecto.</b>
            </p>
            <p>
              {{$proyecto->alcance_proyecto}}
            </p>
            {{-- <p> --}}
            {{-- </p> --}}
          </td>
        </tr>
        <tr>
          <th class="centrar" colspan="6">DATOS DE LA PROPIEDAD INTELECTUAL</th>
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
            <li>
              No se encontraron personas dueñas de la propiedad intelectual.
            </li>
            @endif
          </td>
        </tr>
        <tr>
          <td colspan="6">
            @if ($proyecto->empresas->count() > 0)
            <ul>
              @foreach ($proyecto->empresas as $key => $value)
              <li>
                {{$value->nit}} - {{ $value->entidad->nombre }}
              </li>
              @endforeach
            </ul>
            @else
            <li>
              No se encontraron empresas dueñas de la propiedad intelectual.
            </li>
            @endif
          </td>
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
            <li>
              No se encontraron grupos de investigación dueños de la propiedad intelectual.
            </li>
            @endif
          </td>
        </tr>
      </tbody>
    </table>

  </body>
</html>

{{-- @extends('pdf.illustrated-layout')
@section('title-file', 'Formulario de inicio '. config('app.name'))
@section('content-pdf')
<center>
  <div class="row">
    <h5>Datos del Proyecto</h5>
  </div>
</center>
<div class="row">
  <div class="column">
    <p>Idea de Proyecto: <span style="text-decoration: underline;">{{$proyecto->idea->codigo_idea}}</span></p>
  </div>
  <div class="column">
    <p>Nombre del Proyecto: <span
        style="text-decoration: underline;">{{$proyecto->articulacion_proyecto->actividad->codigo_actividad}}
        {{$proyecto->articulacion_proyecto->actividad->nombre}}</span></p>
  </div>
</div>
<div class="row">
  <div class="column">
    <div class="row">
      <p>Área de Conocmiento: <span style="text-decoration: underline;">{{$proyecto->areaconocimiento->nombre}}</span>
      </p>
    </div>
    @if ($proyecto->areaconocimiento->nombre == 'Otro')
    <div class="row">
      <p>Otro área de conocmiento: <span style="text-decoration: underline;">{{$proyecto->otro_areaconocimiento}}</span>
      </p>
    </div>
    @endif
  </div>
  <div class="column">
    <p>Sublínea: <span style="text-decoration: underline;">{{$proyecto->sublinea->linea->abreviatura}} -
        {{$proyecto->sublinea->nombre}}</span></p>
  </div>
</div>
<div class="row">
  <div class="column">
    <p>TRL que se pretende realizar: <span
        style="text-decoration: underline;">{{$proyecto->trl_esperado == 0 ? 'TRL6' : 'TRL 7 - TRL 8'}}</span></p>
  </div>
  <div class="column">
    <p>¿Recibido a través de fábrica de productividad?: <span
        style="text-decoration: underline;">{{$proyecto->fabrica_productividad == 0 ? 'NO' : 'SI'}}</span></p>
  </div>
</div>
<div class="row">
  <div class="column">
    <p>¿Recibido a través del área de emprendimiento SENA?: <span
        style="text-decoration: underline;">{{$proyecto->reci_ar_emp == 0 ? 'NO' : 'SI'}}</span></p>
  </div>
  <div class="column">
    <div class="row">
      <p>¿El proyecto pertenece a la economía naranja?: <span
          style="text-decoration: underline;">{{$proyecto->economia_naranja == 0 ? 'NO' : 'SI'}}</span></p>
      @if ($proyecto->economia_naranja == 1)
      <p>Tipo de economía naranja: <span style="text-decoration: underline;">{{$proyecto->tipo_economianaranja}}</span>
      </p>
      @endif
    </div>
  </div>
</div>
<div class="row">
  <div class="column">
    <p>¿El proyecto está dirigido a discapacitados?: <span
        style="text-decoration: underline;">{{$proyecto->dirigido_discapacitados == 0 ? 'NO' : 'SI'}}</span></p>
    @if ($proyecto->dirigido_discapacitados == 1)
    <p>Tipo de discapacidad: <span style="text-decoration: underline;">{{$proyecto->tipo_discapacitados}}</span></p>
    @endif
  </div>
  <div class="column">
    <p>¿Articulado con CT+i?: <span style="text-decoration: underline;">{{$proyecto->art_cti == 0 ? 'NO' : 'SI'}}</span>
    </p>
    @if ($proyecto->art_cti == 1)
    <p>Tipo de discapacidad: <span style="text-decoration: underline;">{{$proyecto->nom_act_cti}}</span></p>
    @endif
  </div>
</div>
<h5 style="text-align:center">Talentos que participan en el proyecto.</h5>
<div class="row">
  <table class="striped centered">
    <thead>
      <tr>
        <th style="width: 20%">Talento Interlocutor</th>
        <th style="width: 80%">Talento</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($proyecto->articulacion_proyecto->talentos as $key => $value)
      <tr id="talentoAsociadoAProyecto{{$value->id}}">
        <td>
          {{$value->pivot->talento_lider == 1 ? 'SI' : 'NO'}}
        </td>
        <td>{{$value->user->documento}} - {{$value->user->nombres}} {{$value->user->apellidos}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<h5 style="text-align:center">Objetivos y alcance el proyecto.</h5>
<div class="row">
  <div class="column">
    <p>Objetivo general: <span
        style="text-decoration: underline;">{{$proyecto->articulacion_proyecto->actividad->objetivo_general}}</span></p>
  </div>
  <div class="column">
    <p>Alcance del proyecto: <span style="text-decoration: underline;">{{$proyecto->alcance_proyecto}}</span></p>
  </div>
</div>
<h5 style="text-align: center">Objetivos Específicos</h5>
<div class="row">
  <div class="column">
    <p>Primer objetivo específico: <span
        style="text-decoration: underline;">{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo}}</span>
    </p>
  </div>
  <div class="column">
    <p>Segundo objetivo específico: <span
        style="text-decoration: underline;">{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo}}</span>
    </p>
  </div>
</div>
<div class="row">
  <div class="column">
    <p>Tercer objetivo específico: <span
        style="text-decoration: underline;">{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo}}</span>
    </p>
  </div>
  <div class="column">
    <p>Cuarto objetivo específico: <span
        style="text-decoration: underline;">{{$proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo}}</span>
    </p>
  </div>
</div>
<h5 style="text-align:center">Dueños de la propiedad intelectual.</h5>
<div class="row">
  <h6 style="text-align:center">Persona(s) dueña(s) de la propiedad intelectual.</h6>
  <ul>
    @if ($proyecto->users_propietarios->count() > 0)
    @foreach ($proyecto->users_propietarios as $key => $value)
    <li>
      {{$value->documento}} - {{$value->nombres}} {{$value->apellidos}}
      @endforeach
    </li>
    @else
    <li>
      No se encontraron personas dueñas de la propiedad intelectual.
    </li>
    @endif
  </ul>
</div>
<div class="row">
  <h6 style="text-align:center">Empresa(s) dueña(s) de la propiedad intelectual.</h6>
  <ul>
    @if ($proyecto->empresas->count() > 0)
    @foreach ($proyecto->empresas as $key => $value)
    <li>
      {{$value->nit}} - {{ $value->entidad->nombre }}
      @endforeach
    </li>
    @else
    <li>
      No se encontraron empresas dueñas de la propiedad intelectual.
    </li>
    @endif
  </ul>
</div>
<div class="row">
  <h6 style="text-align:center">Grupo(s) de investigación dueño(s) de la propiedad intelectual.</h6>
  <ul>
    @if ($proyecto->gruposinvestigacion->count() > 0)
    @foreach ($proyecto->gruposinvestigacion as $key => $value)
    <li>
      {{$value->codigo_grupo}} - {{ $value->entidad->nombre }}
      @endforeach
    </li>
    @else
    <li>
      No se encontraron grupos de investigación dueños de la propiedad intelectual.
    </li>
    @endif
  </ul>
</div>
<br>
<br>
<br>
<br>
<div class="row">
  <div class="column">
    <p>______________________________</p>
    <small>Firma del gestor(a): {{$proyecto->articulacion_proyecto->actividad->gestor->user->nombres}}
      {{$proyecto->articulacion_proyecto->actividad->gestor->user->apellidos}}</small>
  </div>
  <div class="column">
    <p>______________________________</p>
    <small>Firma del talento interlocutor</small>
  </div>
</div> --}}