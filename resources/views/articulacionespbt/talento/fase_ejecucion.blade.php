@extends('layouts.app')
@section('meta-title', 'Articulaciones PBT')
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner">
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
                    <li class="active">Ejecución</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12 no-p-h">
                <div class="card mailbox-content">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l12">
                                <div class="mailbox-options">
                                    <ul>
                                        <li class="text-mailbox">Inicio</li>
                                        <li class="text-mailbox active">Ejecución</li>
                                        <li class="text-mailbox">Cierre</li>
                                        <div class="right">
                                            <li class="text-mailbox "> Fase actual: {{$actividad->articulacionpbt->present()->articulacionPbtNameFase()}}</li>
                                            <li class="text-mailbox">Fecha Inicio: {{$actividad->present()->startDate()}}</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    <div class="mailbox-view-header no-m-b no-m-t">
                                        <div class="right mailbox-buttons no-s">

                                        @if ($actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsEjecucion()))
                                            @if ($ultimo_movimiento != null && $actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsEjecucion()) && $ultimo_movimiento->movimiento->movimiento == "solicitó al talento" && $actividad->articulacionpbt->talentos()->wherePivot('talento_lider', 1)->first()->user->id == auth()->user()->id)
                                            <form action="{{route('articulacion.aprobacion', [$actividad->articulacionpbt->id, 'Ejecución'])}}" method="POST" name="frmEjecucionTalento">
                                                {!! method_field('PUT')!!}
                                                @csrf

                                                <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
                                                <input type="hidden" type="text" name="decision" id="decision">
                                                <button type="submit" onclick="preguntaEjecucion(event)" class="waves-effect waves-orange btn orange m-t-xs">
                                                    <i class="material-icons right">done</i>
                                                    Aprobar fase de ejecución
                                                </button>
                                                <button type="submit" onclick="preguntaEjecucionRechazar(event)" class="waves-effect waves-grey btn grey m-t-xs">
                                                    <i class="material-icons right">close</i>
                                                    No aprobar la fase de ejecución
                                                </button>
                                            </form>
                                            @else
                                                @if($ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsAprobar() && $ultimo_movimiento->role->name == App\User::IsTalento())
                                                <a disabled class="waves-effect waves-orange btn disabled m-t-xs">
                                                    El talento interlocutor aprobó la fase de ejecución, aún falta la aprobación del dinamizador
                                                </a>
                                                @endif
                                                @if($ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsNoAprobar() && $ultimo_movimiento->role->name == App\User::IsTalento())
                                                <a disabled class="waves-effect waves-orange btn disabled m-t-xs">
                                                    El talento interlocutor no aprobó la fase de ejecución
                                                </a>
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
                                                <span class="mailbox-title">Nodo</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12 m12 l12">
                                                @include('articulacionespbt.detail.detail-fase-ejecucion')
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

  datatableArchivosArticulacion();
    function preguntaEjecucion(e){
        e.preventDefault();
            Swal.fire({
            title: '¿Está seguro(a) de aprobar la fase de ejecución de esta articulación?',
            text: 'Al hacerlo estás aceptando y aprobando toda la información de esta fase, los documento adjuntos y las asesorias recibidas.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí!'
        }).then((result) => {
            if (result.value) {
            $('#decision').val('aceptado');
                document.frmEjecucionTalento.submit();
            }
        })
    }

    function preguntaEjecucionRechazar(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Está seguro(a) de no aprobar la fase de ejecucion de esta articulación?',
        input: 'text',
        type: 'warning',
        inputValidator: (value) => {
        if (!value) {
            return 'Las observaciones deben ser obligatorias!'
        } else {
            $('#decision').val('rechazado');
            $('#motivosNoAprueba').val(value);
        }
        },
        inputAttributes: {
        maxlength: 100,
        placeHolder: '¿Por qué?'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Enviar observaciones!'
        }).then((result) => {
        if (result.value) {
            document.frmEjecucionTalento.submit();
        }
        })
    }
  function datatableArchivosArticulacion() {
  $('#archivosArticulacion').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('articulacion.files', [$actividad->articulacionpbt->id, 'Ejecución'])}}",
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
