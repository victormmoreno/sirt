@extends('layouts.app')
@section('meta-title', 'Articulaciones PBT')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s8 m8 l5">
            <h5 class="left-align orange-text text-darken-3">
                <i class="material-icons left">
                  autorenew
                </i>
                Articulaciones PBT
            </h5>
        </div>
        <div class="col s4 m4 l5 offset-l2  rigth-align show-on-large hide-on-med-and-down">
            <ol class="breadcrumbs">
                <li><a href="{{route('home')}}">Inicio</a></li>
                <li ><a href="{{route('articulaciones.index')}}">Articulaciones PBT</a></li>
                <li ><a href="{{route('articulaciones.show', $actividad->articulacionpbt->id)}}">detalle</a></li>
                <li class="active">Suspender</li>
            </ol>
        </div>
    </div>
    <div class="row no-m-t no-m-b">
        <div class="card mailbox-content">
          <div class="card-content">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="mailbox-options">
                      <ul>
                          <li class="text-mailbox ">La articulación se encuentra actualmente en la fase de {{$actividad->articulacionpbt->present()->articulacionPbtNameFase()}}</li>
                          <div class="right">
                              <li class="text-mailbox">Fecha Inicio: {{$actividad->present()->startDate()}}</li>   
                          </div>
                      </ul>
                    </div>
                    <div class="mailbox-view no-s">
                        <div class="mailbox-view-header no-m-b no-m-t">
                            <div class="right mailbox-buttons no-s">
                              
                              @if (!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsFinalizado()))
                                @if(!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsSuspendido()))
                                  @if ($ultimo_movimiento == null || $ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsCambiar() || $ultimo_movimiento->movimiento->movimiento  == App\Models\Movimiento::IsNoAprobar() || $ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsReversar())
                                    <a href="{{route('articulacion.notificar.suspension',$actividad->articulacionpbt->id)}}" class="waves-effect waves-orange btn orange m-t-xs">
                                        Solicitar al dinamizador que apruebe la suspensión de la articulación
                                    </a>
                                    @else
                                      @if ($ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsSolicitarDinamizador())
                                        <a disabled class="waves-effect waves-orange btn disabled m-t-xs">
                                            Solicitud enviada al Dinamizador
                                        </a>
                                      @endif
                                      @if($ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsAprobar() && $ultimo_movimiento->role->name == App\User::IsDinamizador())
                                        <a disabled class="waves-effect waves-orange btn disabled m-t-xs">
                                            El Dinamizador aprobó la suspensión
                                        </a>
                                      @endif
                                    @endif
                                  @endif  
                               @endif
                            </div>
                        </div>
                        <div class="mailbox-view-header">
                            <div class="left">
                                <span class="mailbox-title p-v-lg">{{$actividad->present()->actividadCode()}} - {{$actividad->present()->actividadName()}}</span>
                                <div class="left">
                                    <span class="mailbox-title">{{$actividad->present()->actividadUserAsesor()}}</span>
                                    <span class="mailbox-author">{{$actividad->present()->actividadUserRolesAsesor()}} </span>
                                </div>
                            </div>
                            <div class="right mailbox-buttons p-v-lg">
                                <div class="right">
                                    <span class="mailbox-title">{{$actividad->present()->actividadNode()}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="divider mailbox-divider"></div>
                        <div class="mailbox-text">

                            <div class="row">
                              <div class="row search-tabs-row search-tabs-container grey lighten-4">
                                <div class="col s12 m12 l12">
                                    <div class="mailbox-options grey lighten-4 text-white">
                                        <ul class="grey lighten-4 text-white">
                                            <li class="text-mailbox ">Evidencias</li>                                            
                                        </ul>
                                    </div>
                                </div>
                              </div>
                              @if (!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsFinalizado()))
                                @if ($actividad->articulacionpbt->aprobacion_dinamizador_suspender == 0)
                                    <div class="card-panel teal">
                                        <div class="dropzone" id="fase_suspendido_articulacion"></div>
                                    </div>
                                @endif
                              @endif
                              @include('articulacionespbt.archivos_table_fase', ['fase' => 'suspendido'])
                            </div>
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
      datatablesArticulacionSuspendido();
      var Dropzone = new Dropzone('#fase_suspendido_articulacion', {
          url: '{{ route('articulacion.files.upload', $actividad->articulacionpbt->id) }}',
          headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
          params: {
          fase: 'Suspendido'
          },
          paramName: 'nombreArchivo'
      });

    function preguntaSuspender(e){
      e.preventDefault();
      Swal.fire({
      title: '¿Está seguro(a) de suspender esta articulación?',
      text: "No podrás revertir esta acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Sí!'
      }).then((result) => {
        if (result.value) {
          document.frmArticulacionSuspender.submit();
        }
      })
  }

  Dropzone.on('success', function (res) {
    $('#archivosArticulacion').dataTable().fnDestroy();
    datatablesArticulacionSuspendido();
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'El archivo se ha subido con éxito!'
        });
    })

  Dropzone.on('error', function (file, res) {
    var msg = res.errors.nombreArchivo[0];
    $('.dz-error-message:last > span').text(msg);
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'error',
      title: 'El archivo no se ha podido subir!'
    });
  })

  Dropzone.autoDiscover = false;

  function datatablesArticulacionSuspendido() {
  $('#archivosArticulacion').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    "lengthChange": false,
    ajax:{
      url: "{{route('articulacion.files', [$actividad->articulacionpbt->id, 'Suspendido'])}}",
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
      @if (!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsFinalizado()))
      {
        data: 'delete',
        name: 'delete',
        orderable: false,
      },
      @endif
    ],
  });
}
    </script>
@endpush