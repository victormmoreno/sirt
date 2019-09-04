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
              Gestor(a) <b>{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}</b>, usted próximamente será el asesor del proyecto creado a partir de la idea de proyecto <b>{{ $proyecto->idea->nombre_proyecto }}</b> con el
              código de idea de proyecto: <b>{{ $proyecto->idea->codigo_idea }}</b>, la cual fue aprobada por el CSIBT ó fue inscrita como idea de proyecto con empresa ó grupo de investigación, si esta información no concuerda con lo esperado ó no está de acuerdo con iniciar este proyecto,
              entonces por favor, seleccione el botón <b>"No Aprobar"</b>, de lo contrario, puede pulsar <b>"Aprobar"</b> y luego Guardar la información.
              <br>
              Mas abajo encontrará información relacionada con el proyecto.
              <br>
              Debe tener en cuenta, que dicha información solo será válida en caso de aprobar el proyecto.
            </p>
          </div>
          <div class="divider"></div>
          <div class="row">
            <div class="col s12 m12 l12">
              <form action="{{route('proyecto.update.aprobacion', $proyecto->id)}}" method="POST" onsubmit="return checkSubmit()">
                @include('proyectos.aprobacion_form')
                <center>
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Guardar</button>
                  <a href="{{ route('proyecto') }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
