@extends('pdf.illustrated-layout')
@section('title-file', 'Usos de Infraestructura '. config('app.name'))
@section('content-pdf')
  <center>
    <div class="row">
      <h5>Datos del Proyecto</h5>
    </div>
  </center>
  <table class="striped centered">
    <thead>
      <tr>
        <th>Código del proyecto</th>
        <th>Nombre del proyecto</th>
        <th>Gestor a cargo del proyecto</th>
        <th>Sublínea tecnológica</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}</td>
        <td>{{ $proyecto->articulacion_proyecto->actividad->nombre }}</td>
        <td>{{ $proyecto->articulacion_proyecto->actividad->gestor->user->nombres }} {{ $proyecto->articulacion_proyecto->actividad->gestor->user->apellidos }}</td>
        <td>{{ $proyecto->sublinea->linea->abreviatura }} - {{ $proyecto->sublinea->nombre }}</td>
      </tr>
    </tbody>
  </table>

  <center>
    <div class="row">
      <h5>Talentos del Proyecto</h5>
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
      <h5>Usos de Infraestructura</h5>
    </div>
  </center>
  <table class="striped centered">
    <thead>
      <tr>
        <th width="10%">Fecha del Uso de Infraestructura</th>
        <th width="10%">Horas de Asesoria Directa</th>
        <th width="10%">Horas de Asesoria Indirecta</th>
        <th>Equipos</th>
        <th>Materiales de Formación</th>
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
        </tr>
      @empty
        <tr>
          <td>No se registran usos de infraestructura</td>
          <td>No se registran usos de infraestructura</td>
          <td>No se registran usos de infraestructura</td>
          <td>No se registran usos de infraestructura</td>
          <td>No se registran usos de infraestructura</td>
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
      <small>Firma del gestor(a) - {{$proyecto->articulacion_proyecto->actividad->gestor->user->nombres}} {{$proyecto->articulacion_proyecto->actividad->gestor->user->apellidos}}</small>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="column">
      <div>__________________________________________________________</div>
      <small>Firma del talento interlocutor - {{$proyecto->articulacion_proyecto->talentos()->wherePivot('talento_lider', '=', 1)->first()->user->nombres}} {{$proyecto->articulacion_proyecto->talentos()->wherePivot('talento_lider', '=', 1)->first()->user->apellidos}}</small>
    </div>
  </div>
  <br>
@endsection
