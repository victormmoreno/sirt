@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('proyecto')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Proyectos
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('proyectos.navegacion_fases')
              <div class="row">
                <div class="col s12 m6 l6 center">
                    <a class="btn-large blue-grey m-b-xs" href="{{route('proyecto.entregables.inicio', $proyecto->id)}}">
                        <i class="material-icons left">library_books</i>
                        Entregables de la Fase de Planeación.
                    </a>
                </div>
            </div>
              <form method="POST">
                {!! method_field('PUT')!!}
                @include('proyectos.form_planeacion', [
                'btnText' => 'Modificar'])
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>
@endsection