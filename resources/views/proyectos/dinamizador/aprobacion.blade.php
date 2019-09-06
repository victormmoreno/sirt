@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <h5>
        <a class="footer-text left-align" href="{{ route('proyecto.pendientes') }}">
          <i class="left material-icons">arrow_back</i>
        </a> Proyectos Pendientes
      </h5>
      <div class="card">
        <div class="card-content">
          <div class="row">
            <p class="flow-text">
              El gestor(a) <b>{{ $proyecto->articulacion_proyecto->actividad->gestor->user->nombres }} {{ $proyecto->articulacion_proyecto->actividad->gestor->user->apellidos }}</b> ha registrado un Proyecto de Base Tecnológica, pero antes de comenzar su desarrollo,
              el dinamizador, gestor y talento líder, deben Aprobar el proyecto.
              <br>
              Mas abajo, podrá encontrar información del proyecto y su idea de proyecto.
              <br>
              En caso de que todos aprueben el proyecto, el sistema generará el acuerdo de confidencialidad y compromiso, esta se podrá consultar en el apartado de Entregables del proyecto.
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
