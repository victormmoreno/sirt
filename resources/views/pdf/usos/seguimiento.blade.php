@extends('pdf.illustrated-layout')
@section('title-file', 'Asesorías y usos'. config('app.name'))
@section('content-pdf')
  <center>
    <div class="row">
      @if ($tipo_actividad == 'proyecto')
        <h5>Datos del Proyecto</h5>
      @else
        <h5>Datos de la Articulación</h5>
      @endif
    </div>
  </center>
  <table class="striped centered">
    <thead>
      <tr>
        @if ($tipo_actividad == 'proyecto')
          <th>Código del proyecto</th>
          <th>Nombre del proyecto</th>
          <th>Gestor a cargo del proyecto</th>
          <th>Sublínea tecnológica</th>
        @else
          <th>Código de la articulación</th>
          <th>Nombre de la articulación</th>
          <th>Gestor a cargo de la articulación</th>
        @endif
      </tr>
    </thead>
    <tbody>
      <tr>
        @if ($tipo_actividad == 'proyecto')
          <td>{{ $actividad->articulacion_proyecto->actividad->codigo_actividad }}</td>
          <td>{{ $actividad->articulacion_proyecto->actividad->nombre }}</td>
          <td>{{ $actividad->articulacion_proyecto->actividad->gestor->user->nombres }} {{ $actividad->articulacion_proyecto->actividad->gestor->user->apellidos }}</td>
          <td>{{ $actividad->sublinea->linea->abreviatura }} - {{ $actividad->sublinea->nombre }}</td>
        @else
          <td>{{ $actividad->articulacion_proyecto->actividad->codigo_actividad }}</td>
          <td>{{ $actividad->articulacion_proyecto->actividad->nombre }}</td>
          <td>{{ $actividad->articulacion_proyecto->actividad->gestor->user->nombres }} {{ $actividad->articulacion_proyecto->actividad->gestor->user->apellidos }}</td>
        @endif
      </tr>
    </tbody>
  </table>

  <center>
    <div class="row">
      @if ($tipo_actividad == 'proyecto')
        <h5>Talentos del Proyecto</h5>
      @else
        <h5>Talentos de la Articulación</h5>
      @endif
    </div>
  </center>
  <table class="striped centered">
    <thead>
      <tr>
        <th>Número de documento</th>
        <th>Nombres y apellidos</th>
        <th>Correo electrónico</th>
        <th>Número de contacto</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($talentos->articulacion_proyecto->talentos as $value)
        <tr>
          <td>{{ $value->user->documento }}</td>
          <td>{{ $value->user->nombres }} {{ $value->user->apellidos }}</td>
          <td>{{ $value->user->email }}</td>
          <td>{{ $value->user->celular }} {{ $value->user->telefono }}</td>
        </tr>
        @empty
          <tr>
            <td>No hay información disponible</td>
            <td>No hay información disponible</td>
            <td>No hay información disponible</td>
            <td>No hay información disponible</td>
          </tr>
      @endforelse
    </tbody>
  </table>

  <center>
    <div class="row">
      <h5>Asesorías y usos</h5>
    </div>
  </center>
  <table class="striped centered">
    <thead>
      <tr>
        <th width="10%">Fecha de la Asesoría y uso</th>
        <th width="10%">Horas de Asesoria Directa</th>
        <th width="10%">Horas de Asesoria Indirecta</th>
        <th>Equipos</th>
        <th>Materiales de Formación</th>
        <th>Descripción</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($usos->articulacion_proyecto->actividad->usoinfraestructuras as $value)
        <tr>
          <td>{{ $value->fecha->isoFormat('YYYY-MM-DD') }}</td>
          <td>{{ $value->usogestores->sum('pivot.asesoria_directa') }}</td>
          <td>{{ $value->usogestores->sum('pivot.asesoria_indirecta') }}</td>
          <td>
            <table class="interna centered">
              <thead>
                <tr>
                  <th style="border: none">Equipo</th>
                  <th style="border: none">Horas de Uso</th>
                </tr>
              </thead>
              <tbody>
                @forelse($value->usoequipos as $equipos)
                  <tr>
                    <td style="border: none">{{$equipos->nombre}} - {{$equipos->marca}}</td>
                    <td style="border: none">{{$equipos->pivot->tiempo}}</td>
                  </tr>
                @empty
                  <tr>
                    <td style="border: none">No se usaron equipos</td>
                    <td style="border: none">No se usaron equipos</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </td>
          <td>
            <table class="interna centered">
              <thead>
                <tr>
                  <th style="border: none">Material</th>
                  <th style="border: none">Unidades</th>
                </tr>
              </thead>
              <tbody>
                @forelse($value->usomateriales as $materiales)
                  <tr style="border: none">
                    <td style="border: none">{{$materiales->nombre}}</td>
                    <td style="border: none">{{$materiales->pivot->unidad}}</td>
                  </tr>
                @empty
                  <tr>
                    <td style="border: none">No se consumieron materiales</td>
                    <td style="border: none">No se consumieron materiales</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </td>
          <td>
            {{$value->descripcion}}
          </td>
        </tr>
      @empty
        <tr>
          <td>No se registran asesorías y usos</td>
          <td>No se registran asesorías y usos</td>
          <td>No se registran asesorías y usos</td>
          <td>No se registran asesorías y usos</td>
          <td>No se registran asesorías y usos</td>
          <td>No se registran asesorías y usos</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  <br>
  <br>
  <br>
  <br>
  <div class="row">
    <div class="column">
      <div>__________________________________________________________</div>
      <small>Firma del gestor(a) - {{$actividad->articulacion_proyecto->actividad->gestor->user->nombres}} {{$actividad->articulacion_proyecto->actividad->gestor->user->apellidos}}</small>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="column">
      <div>__________________________________________________________</div>
      <small>Firma del talento interlocutor - {{$actividad->articulacion_proyecto->talentos()->wherePivot('talento_lider', '=', 1)->first()->user->nombres}} {{$actividad->articulacion_proyecto->talentos()->wherePivot('talento_lider', '=', 1)->first()->user->apellidos}}</small>
    </div>
  </div>
  <br>
@endsection
