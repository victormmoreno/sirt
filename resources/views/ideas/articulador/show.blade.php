@extends('layouts.app')
@section('meta-title', 'Ideas de Proyecto')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('idea.index')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Ideas de Proyecto
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <br>
              <center>
                <span class="card-title center-align"><b>Idea de proyecto - {{ $idea->codigo_idea }}</b></span>
              </center>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m3 l3">
                  <ul class="collection with-header">
                    <li class="collection-header"><h5>Opciones</h5></li>
                    @if ($idea->estadoIdea->nombre == 'Postulado')
                    <li class="collection-item">
                      <form action="{{route('idea.aceptar.postulacion', $idea->id)}}" method="POST" name="frmAceptarPostulacionIdea">
                      {!! method_field('PUT')!!}
                      @csrf
                      <input type="hidden" name="txtobservacionesAceptacion" id="txtobservacionesAceptacion" value="">
                        <a href="" onclick="confirmacionAceptacionPostulacion(event)">
                          <div class="card-panel teal lighten-2 black-text center">
                            Aceptar idea de proyecto
                          </div>
                        </a>
                      </form>
                    </li>
                    <li class="collection-item">
                      <form action="{{route('idea.rechazar.postulacion', $idea->id)}}" method="POST" name="frmRechazarPostulacionIdea">
                        {!! method_field('PUT')!!}
                        @csrf
                        <input type="hidden" name="txtmotivosRechazo" id="txtmotivosRechazo" value="">
                        <a href="" onclick="confirmacionRechazoPostulacion(event)">
                          <div class="card-panel red lighten-2 black-text center">
                            Devolver idea de proyecto
                          </div>
                        </a>
                      </form>
                    </li>
                    @endif
                    <li class="collection-item">
                      @include('ideas.historial_cambios')
                    </li>
                  </ul>
                </div>
                <div class="col s12 m9 l9">
                  @include('ideas.detalle')
                  <center>
                    <a href="{{route('idea.index')}}" class="waves-effect red lighten-2 btn center-aling">
                      <i class="material-icons right">backspace</i>Cancelar
                    </a>
                  </center>
                </div>
              </div>
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
    function confirmacionAceptacionPostulacion(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de aceptar la postulación de esta idea de proyecto?',
    input: 'textarea',
    inputPlaceholder: 'Puedes dejar algunas observaciones para el talento',
    type: 'warning',
    inputValidator: (value) => {
      if (!value) {
        return 'Se necesitan unas observaciones!'
      } else {
        $('#txtobservacionesAceptacion').val(value);
      }
    },
    inputAttributes: {
      maxlength: 2100
    },
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        document.frmAceptarPostulacionIdea.submit();
        // window.location.href = "{{ route('idea.aceptar.postulacion', $idea->id) }}";
      }
    })
  }

  function confirmacionRechazoPostulacion(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de devolver la postulación de esta idea de proyecto?',
    input: 'textarea',
    inputPlaceholder: 'Por favor, escriba los motivos por los cuales se está devolviendo la postulación de la idea de proyecto',
    type: 'warning',
    inputValidator: (value) => {
      if (!value) {
        return 'Los motivos por los cuales se devuelve la idea deben ser obligatorios!'
      } else {
        $('#txtmotivosRechazo').val(value);
      }
    },
    inputAttributes: {
      maxlength: 2100
    },
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Enviar observaciones!'
    }).then((result) => {
      if (result.value) {
        document.frmRechazarPostulacionIdea.submit();
      }
    })
  }
    </script>
@endpush