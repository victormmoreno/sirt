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
                    <li class="active">Cierre</li>
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
                                        <li class="text-mailbox ">Ejecución</li>
                                        <li class="text-mailbox active">Cierre</li>
                                        <div class="right">
                                            <li class="text-mailbox "> Fase actual: {{$actividad->articulacionpbt->present()->articulacionPbtNameFase()}}</li>
                                            <li class="text-mailbox">Fecha Inicio: {{$actividad->present()->startDate()}}</li>   
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    <div class="mailbox-view-header no-m-b no-m-t">
                                        <div class="right mailbox-buttons no-s">
                                            @if ($actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsCierre()))
                                                @if ( ($ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsCambiar() || $ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsNoAprobar() || $ultimo_movimiento->movimiento == App\Models\Movimiento::IsReversar())
                                                || ($ultimo_movimiento->role->name == App\User::IsDinamizador() && $ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsAprobar()) )
                                                <a href="{{route('articulacion.solicitar.aprobacion', [$actividad->articulacionpbt->id, 'Cierre'])}}" class="waves-effect waves-light btn orange m-t-xs">
                                                    Solicitar al talento que apruebe la fase de Cierre
                                                </a>
                                                @else
                                                    @if ($ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsSolicitarTalento())
                                                    <a disabled class="waves-effect waves-light btn disabled m-t-xs">
                                                        Se envió la solicitud de aprobación al talento interlocutor
                                                    </a>
                                                    @endif
                                                    @if($ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsAprobar() && $ultimo_movimiento->role->name == App\User::IsTalento())
                                                        <a disabled class="waves-effect waves-light btn disabled m-t-xs">
                                                            El talento interlocutor aprobó la fase de Cierre, aún falta la aprobación del dinamizador
                                                        </a>
                                                    @endif
                                                @endif
                                            @endif  
                                            <a target="_blank" href="{{route('pdf.articulacion.cierre', $actividad->articulacionpbt->id)}}" class="waves-effect waves-grey btn-flat m-t-xs">Descargar Formulario</a>                   
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
                                    <div class="divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12 m12 l12">
                                            @if ($actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::Iscierre()))
                                                <form id="frmArticulacionFaseCierre" action="{{route('articulacion.update.cierre', $actividad->articulacionpbt->id)}}" method="POST" onsubmit="return checkSubmit()">
                                                    {!! method_field('PUT')!!}
                                                    @include('articulacionespbt.form.form_cierre', ['btnText' => 'Modificar'])
                                                    <div class="row">
                                                        @include('articulacionespbt.table-archive-fase', ['fase' => 'Cierre'])
                                                    </div>
                                                    <center>
                                                        @if ($actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::Iscierre()))
                                                        <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
                                                            <i class="material-icons right">done</i>
                                                            Guardar
                                                        </button>
                                                        @endif
                                                        <a href="{{route('proyecto.ejecucion', $actividad->articulacionpbt->id)}}" class="waves-effect red lighten-2 btn center-aling">
                                                            <i class="material-icons right">backspace</i>Cancelar
                                                        </a>
                                                    </center>
                                                </form>
                                                @else
                                                    <div class="row ">
                                                        <div class="col s12 m12 l12">
                                                            <div class="card card-transparent">
                                                                <div class="card-content">
                                                                    <div class="search-result">
                                                                        <p class="search-result-description text-center">La articulación no se encuentra en esta fase</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
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
    $(document).ready(function() {
        articulacionCierre.checkedTypePostulacion();
        articulacionCierre.checkedAprobacion();
    });
    datatableArchiveArticulacion_cierre();

    var articulacionCierre = {
        checkedTypePostulacion: function(){
            let tipopostulacion = $('input:radio[name=txttipopostulacion]:checked').val();
            if (tipopostulacion == "si") {
                $(".r-si").show();
                $(".r-no").hide();
            }else if(tipopostulacion == "no"){
                $(".r-no").show();
                $(".r-si").hide();
            }else{
                $(".r-si").show();
                $(".r-no").hide();
            }
        },
        checkedAprobacion: function(){
            let aprobacion = $('input:radio[name=txtaprobacion]:checked').val();
            console.log(aprobacion);
            if (aprobacion == "aprobado") {
                $(".r-aprobado").show();
                $(".r-no-aprobado").hide();
            }else if(aprobacion == "noaprobado"){
                $(".r-no-aprobado").show();
                $(".r-aprobado").hide();
            }else{
                $(".r-aprobado").show();
                $(".r-no-aprobado").hide();
            }
        },
    }

  function datatableArchiveArticulacion_cierre() {
    $('#archivosArticulacion').DataTable({
        language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: false,
        ajax:{
        url: "{{route('articulacion.files', [$actividad->articulacionpbt->id, 'Cierre'])}}",
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
        @if ($actividad->articulacionpbt->present()->articulacionPbtNameFase() == 'Cierre')
        {
            data: 'delete',
            name: 'delete',
            orderable: false,
        },
        @endif
        ],
    });
    }

var Dropzone = new Dropzone('#fase_cierre_articulacion', {
        url: '{{ route('articulacion.files.upload', $actividad->articulacionpbt->id) }}',
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
        params: {
        fase: 'Cierre'
        },
        paramName: 'nombreArchivo'
    });

    Dropzone.on('success', function (res) {
        $('#archivosArticulacion').dataTable().fnDestroy();
        datatableArchiveArticulacion_cierre();
        Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'El archivo se ha subido con éxito!'
        });
    });

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
    });

    Dropzone.autoDiscover = false;
</script>
@endpush