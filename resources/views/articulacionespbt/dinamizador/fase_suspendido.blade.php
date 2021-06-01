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
                <li class="active">Inicio</li>
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
                                    @if ($ultimo_movimiento != null && $ultimo_movimiento->role->name == App\User::IsArticulador() && $ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsSolicitarDinamizador())
                                        <form action="{{route('articulacion.update.suspendido', $actividad->articulacionpbt->id)}}" method="POST" name="frmSuspendidoDinamizador" onsubmit="return checkSubmit()">
                                            {!! method_field('PUT')!!}
                                            @csrf
                                            <center>
                                            <button type="submit" onclick="preguntaSuspendido(event)" value="send" {{$actividad->articulacionpbt->aprobacion_dinamizador_suspendido == 0 ? '' : 'disabled'}}
                                                class="waves-effect waves-orange btn orange m-t-xs">
                                                <i class="material-icons right">done</i>
                                                    Aprobar suspensión de la articulación
                                            </button>
                                            </center>
                                        </form>
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
                              <div class="col s12 m12 l12">
                                    <div class="row search-tabs-row search-tabs-container grey lighten-4">
                                        <div class="col s12 m12 l12">
                                            <div class="mailbox-options grey lighten-4 text-white">
                                                <ul class="grey lighten-4 text-white">
                                                    <li class="text-mailbox ">Evidencias</li>                                            
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
    </div>
  </div>
</main>
@endsection
@push('script')
    <script>
        datatablesArticulacionSuspendido();
   
        function preguntaSuspendido(e){
            e.preventDefault();
            Swal.fire({
                title: '¿Está seguro(a) de aprobar la suspensión de esta articulación?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí!'
            }).then((result) => {
                if (result.value) {
                    document.frmSuspendidoDinamizador.submit();
                }
            })
        }

        function datatablesArticulacionSuspendido() {
            $('#archivosArticulacion').DataTable({
                language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
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
                }
                ],
            });
        }
    </script>
@endpush