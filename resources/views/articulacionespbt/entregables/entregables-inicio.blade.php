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
                    <li class="active">Inicio</li>
                    <li class="active">Entregables</li>
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
                                        <li class="text-mailbox active">Inicio</li>
                                        <li class="text-mailbox">Ejecución</li>
                                        <li class="text-mailbox">Cierre</li>
                                        <div class="right">
                                            <li class="text-mailbox "> Fase actual: {{$actividad->articulacionpbt->present()->articulacionPbtNameFase()}}</li>
                                            <li class="text-mailbox">Fecha Inicio: {{$actividad->present()->startDate()}}</li>   
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    
                                    <div class="mailbox-view-header">
                                        <div class="left">
                                            <span class="mailbox-title">{{$actividad->present()->actividadCode()}} - {{$actividad->present()->actividadName()}}</span>
                                            
                                            <div class="left">
                                                <span class="mailbox-title">{{$actividad->present()->actividadUserAsesor()}}</span>
                                                <span class="mailbox-author">{{$actividad->present()->actividadUserRolesAsesor()}} </span>
                                            </div>
                                        </div>
                                        <div class="right mailbox-buttons">
                                            <div class="right">
                                                <span class="mailbox-title">{{$actividad->present()->actividadNode()}}</span>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                   
                                    <div class="mailbox-text">
                                        
                                        <div class="row">
                                            
                                            <div class="card card-transparent">
                                                <div class="card-content">
                                                  <div class="row">
                                                    <h5 class="center orange-text">Entregables de la fase de inicio.</h5>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col s12 m12 l12">
                                                        <form action="{{route('articulacion.update.entregables.inicio', $actividad->articulacionpbt->id)}}" method="POST" onsubmit="return checkSubmit()">
                                                            @include('articulacionespbt.entregables.form.form_entregables_inicio')
                                                            @include('articulacionespbt.archivos_table_fase', ['fase' => 'inicio'])
                                                            <div class="divider"></div>
                                                            <center>
                                                            @if ($actividad->articulacionpbt->present()->articulacionPbtNameFase() == 'Inicio')
                                                                <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                                                            @endif
                                                            <a href="{{ route('articulacion.show.inicio', $actividad->articulacionpbt->id) }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                                                            </center>
                                                        </form>
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
            </div>
        </div>
    </div>
    
    @include('ideas.modals')
</main>
@endsection
@push('script')
  <script>
    datatableArchiveArticulacion_inicio();

    var Dropzone = new Dropzone('#fase_inicio_articulacion', {
        url: '{{ route('articulacion.files.upload', $actividad->articulacionpbt->id) }}',
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
        params: {
        fase: 'Inicio'
        },
        paramName: 'nombreArchivo'
    });

    Dropzone.on('success', function (res) {
        $('#archivosArticulacion').dataTable().fnDestroy();
        datatableArchiveArticulacion_inicio();
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

    function datatableArchiveArticulacion_inicio() {
    $('#archivosArticulacion').DataTable({
        language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: false,
        ajax:{
        url: "{{route('articulacion.files', [$actividad->articulacionpbt->id, 'Inicio'])}}",
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
        @if ($actividad->articulacionpbt->present()->articulacionPbtNameFase() == 'Inicio')
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
