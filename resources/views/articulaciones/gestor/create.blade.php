@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('meta-content', 'Articulaciones')
@section('meta-keywords', 'Articulaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('articulacion')}}">
              <i class="left material-icons arrow-l">arrow_back</i>
            </a> Articulaciones con Grupos de Investigación
          </h5>
          
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <br>
                  <center>
                    <span class="card-title center-align">Nueva Articulación - {{ auth()->user()->nombres}} {{auth()->user()->apellidos}}</span>
                  </center>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="card red lighten-3">
                        <div class="row">
                          <div class="col s12 m12">
                            <div class="card-content white-text">
                              <p><i class="material-icons left">info_outline</i>Los datos marcados con * son obligatorios</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <form id="frmArticulacion_FaseInicio" method="POST" action="{{route('articulacion.store')}}">
                    @include('articulaciones.gestor.form_inicio', [
                        'btnText' => 'Guardar'])
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
@include('articulaciones.modals')
@push('script')
<script>
    $(document).ready(function() {
        consultarTalentosDeTecnoparque_Articulacion_FaseInicio_table('#talentosDeTecnoparque_Articulacion_FaseInicio_table', 'add_articulacion');
    });
</script>
@endpush
