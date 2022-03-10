@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('proyecto')}}">
            <i class="material-icons arrow-l left">arrow_back</i>
          </a> Proyectos de Base Tecnológica
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('proyectos.navegacion_fases')
              <div class="divider"></div>
              <br />
              <form action="{{route('proyecto.update.talentos', $proyecto->id)}}" method="POST" id="frmUpdateTalentos" name="frmUpdateTalentos">
                {!! method_field('PUT')!!}
                @csrf
                @include('proyectos.gestor.componente_talentos_proyecto', ['proyecto' => $proyecto])
                <div class="divider"></div>
                <center>
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
                    <i class="material-icons right">done</i>
                    Guardar
                  </button>
                  <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
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
