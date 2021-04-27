@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5 class="orange-text">
          <a class="footer-text left-align " href="{{route('proyecto')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Proyectos de Base Tecnológica
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <br>
              <center>
                <span class="card-title center-align orange-text"><b>Nuevo Proyecto - {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}</b></span>
              </center>
              <div class="divider"></div>
              <div class="col s12 m12 l12">
                <div class="card-content red lighten-3 white-text">
                  <p>
                    <i class="material-icons left">info_outline</i>
                    Los elementos con (*) son obligatorios
                  </p>
                </div>
              </div>
              <br/>
              <form id="frmProyectos_FaseInicio" action="{{route('proyecto.store')}}" method="POST">
              @include('proyectos.gestor.form_inicio', [
              'btnText' => 'Guardar'])
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>
@include('proyectos.modals')
@endsection
@push('script')
<script>
  $( document ).ready(function() {
  consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table('#talentosDeTecnoparque_Proyecto_FaseInicio_table', 'add_proyecto');
  });
        
</script>
@endpush