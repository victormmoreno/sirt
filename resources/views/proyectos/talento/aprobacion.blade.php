@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <h5>
        <a class="footer-text left-align" href="{{ route('proyecto') }}">
          <i class="left material-icons">arrow_back</i>
        </a> Proyectos
      </h5>
      <div class="card">
        <div class="card-content">
          <div class="row">
            <p class="flow-text">
              Talento <b>{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}</b>, usted está próximo a iniciar el desarrollo de un Proyecto de Base Tecnolópgica con Tecnoparque,
              <b>{{ $proyecto->idea->nombre_proyecto }}</b> con el código de idea de proyecto: <b>{{ $proyecto->idea->codigo_idea }}</b>, si usted está seguro que la información mostrada mas abajo es correcta,
              y está de acuerdo con iniciar el desarrollo de un proyecto en Tecnparque nodo <b>{{ $proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre }}</b>, puede seleccionar la opción "Aprobar" ó "No Aprobar"
              en caso contrario, también es importante leer la información que se muestra a continuación.
            </p>
          </div>
          <div class="divider"></div>
          <div class="row">
            <div class="col s12 m12 l12">
              <form action="{{route('proyecto.update.aprobacion', $proyecto->id)}}" method="POST" onsubmit="return checkSubmit()">
                @include('proyectos.aprobacion_form')
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
