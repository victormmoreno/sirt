@extends('pdf.illustrated-layout')
@section('title-file', 'Usos de Infraestructura '. config('app.name'))
@section('content-pdf')
  <center>
    <div class="row">
      <h5>Datos del Proyecto</h5>
    </div>
  </center>
  <div class="row">
    <div class="col s4 m4 l4">
      <b>Código del proyecto: </b> {{ $proyecto{'codigo_proyecto'} }} <br>
      <b>Nombre del proyecto: </b> {{ $proyecto{'nombre'} }} <br>
    </div>
    <div class="col s4 m4 l4">
      <b>Gestor a cargo del proyecto: </b> {{ $proyecto['nombre_gestor'] }} <br>
      <b>Línea tecnológica: </b> {{ $proyecto['nombre_linea'] }} <br>
    </div>
    <div class="col s4 m4 l4">

    </div>
  </div>
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
    </tbody>
</table>
@endsection
