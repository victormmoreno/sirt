@extends('layouts.app')
@section('meta-title', 'Articulacion G.I')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <h5>
                    <a class="footer-text left-align" href="{{route('articulacion')}}">
                        <i class="material-icons arrow-l left">arrow_back</i>
                    </a> Articulaciones con Grupos de Investigación
                </h5>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            @include('articulaciones.navegacion_fases')
                            <div class="divider"></div>
                            <br />
                            <form action="{{route('articulacion.update.cierre', $articulacion->id)}}" method="POST" name="frmCierreDinamizador">
                                {!! method_field('PUT')!!}
                                @csrf
                                @include('articulaciones.detalle_fase_cierre')
                                <div class="divider"></div>
                                <center>
                                  @if ($articulacion->articulacion_proyecto->aprobacion_dinamizador_ejecucion == 1)
                                    @if ($articulacion->articulacion_proyecto->actividad->aprobacion_dinamizador == 1)
                                    <button type="submit" value="send" class="waves-effect cyan darken-1 btn center-aling" disabled>
                                      <i class="material-icons right">done</i>
                                      Ya se ha aprobado la fase de cierre.
                                    </button>
                                    @else
                                    <button type="submit" onclick="preguntaCierre(event)" value="send" class="waves-effect cyan darken-1 btn center-aling">
                                      <i class="material-icons right">done</i>
                                      Aprobar fase de cierre.
                                      </button>
                                    @endif
                                  @else
                                  <button type="submit" value="send" class="waves-effect cyan darken-1 btn center-aling">
                                      <i class="material-icons right">done</i>
                                      El Dinamizador aún no ha dado su aprobación de la fase de Ejecución
                                  </button>
                                  @endif
                                    <a href="{{route('articulacion')}}" class="waves-effect red lighten-2 btn center-aling">
                                        <i class="material-icons right">backspace</i>Cancelar
                                    </a>
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
@push('script')
<script>
    $( document ).ready(function() {
    datatableArchivosDeUnaArticulacion_cierre();
  });

  function preguntaCierre(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de aprobar la fase de cierre de esta articulación?',
    // text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        document.frmCierreDinamizador.submit();
      }
    })
  }
  function changeToPlaneacion() {
    window.location.href = "{{ route('articulacion.planeacion', $articulacion->id) }}";
  }

  function changeToInicio() {
    window.location.href = "{{ route('articulacion.inicio', $articulacion->id) }}";
  }

  function changeToEjecucion() {
    window.location.href = "{{ route('articulacion.ejecucion', $articulacion->id) }}";
  }

  function changeToCierre() {
    window.location.href = "{{ route('articulacion.cierre', $articulacion->id) }}";
  }

  function datatableArchivosDeUnaArticulacion_cierre() {
  $('#archivosDeUnaArticulacion').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('articulacion.files', [$articulacion->id, 'Cierre'])}}",
      type: "get",
    },
    columns: [
      {
        data: 'file',
        name: 'file',
        orderable: false,
      },
      {
        data: 'download',
        name: 'download',
        orderable: false,
      },
    ],
  });
}
</script>
@endpush