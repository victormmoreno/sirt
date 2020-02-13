@extends('layouts.app')
@section('meta-title', 'Proyectos de Desarrollo Tecnológico')
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
                  <a class="btn-large blue m-b-xs" href="{{route('pdf.proyecto.incio', $proyecto->id)}}"
                    target="_blank">
                    <i class="material-icons left">file_download</i>
                    Descargar formulario.
                  </a>
                </div>
                <div class="col s12 m6 l6 center">
                  <a class="btn-large blue-grey m-b-xs" href="{{route('proyecto.entregables.cierre', $proyecto->id)}}">
                    <i class="material-icons left">library_books</i>
                    Entregables de la Fase de Cierre.
                  </a>
                </div>
              </div>
              <form id="frmProyectos_FaseCierre_Update" action="{{route('proyecto.update.cierre', $proyecto->id)}}"
                method="POST">
                {!! method_field('PUT')!!}
                @include('proyectos.gestor.form_cierre', [
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
@push('script')
<script>
  function changeToPlaneacion() {
    window.location.href = "{{ route('proyecto.planeacion', $proyecto->id) }}";
  }

  function changeToInicio() {
    window.location.href = "{{ route('proyecto.inicio', $proyecto->id) }}";
  }

  function changeToEjecucion() {
    window.location.href = "{{ route('proyecto.ejecucion', $proyecto->id) }}";
  }

  function changeToCierre() {
    window.location.href = "{{ route('proyecto.cierre', $proyecto->id) }}";
  }
</script>
@endpush