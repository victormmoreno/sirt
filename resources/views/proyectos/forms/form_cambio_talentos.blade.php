@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{ route('proyecto.inicio', $proyecto->id) }}">
            <i class="material-icons arrow-l left">arrow_back</i>
          </a> Proyectos de Base Tecnológica
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('proyectos.titulo')
              @include('proyectos.historial_cambios')
              <div class="col s12 offset-m3 offset-l3">
                @include('proyectos.detalles.detalle_general')
              </div>
              <br />
              <form action="{{route('proyecto.update.talentos', $proyecto->id)}}" method="POST" id="frmUpdateTalentos" name="frmUpdateTalentos">
                {!! method_field('PUT')!!}
                @csrf
                @include('proyectos.detalles.componente_talentos_proyecto', ['proyecto' => $proyecto])
                <div class="divider"></div>
                <center>
                  <button type="submit" class="waves-effect waves-light btn bg-secondary center-align">
                    <i class="material-icons left">send</i>
                    Guardar
                  </button>
                  <a href="{{ route('proyecto.inicio', $proyecto->id) }}" class="waves-effect waves-light btn bg-danger center-align">
                    <i class="material-icons right">backspace</i>Cancelar
                  </a>
                </center>
              </form>
            </div>
        </div>
        </div>
    </div>
</main>
@endsection
@push('script')
    <script>
        $( document ).ready(function() {
            consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table('#talentosDeTecnoparque_Proyecto_FaseInicio_table', 'add_proyecto');
        })
    </script>
@endpush
