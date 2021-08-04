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
                    <i class="material-icons left"> autorenew</i> Articulaciones PBT
                </h5>
            </div>
            <div class="col s4 m4 l5 offset-l2  rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li ><a href="{{route('articulaciones.index')}}">Articulaciones PBT</a></li>
                    <li ><a href="{{route('articulaciones.show', $articulacion->id)}}">detalle</a></li>
                    <li class="active">Miembros</li>
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
                                        <li class="text-mailbox ">La articulación se encuentra actualmente en la fase de {{$articulacion->present()->articulacionPbtNameFase()}}</li>
                                        <div class="right">
                                            <li class="text-mailbox">Fecha Inicio: {{$articulacion->present()->articulacionPbtstartDate()}}</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">

                                    <div class="mailbox-view-header">
                                        <div class="left">
                                            <span class="mailbox-title p-v-lg">{{$articulacion->present()->articulacionCode()}} - {{$articulacion->present()->articulacionName()}}</span>
                                            <div class="left">
                                                <span class="mailbox-title">{{$articulacion->present()->articulacionPbtUserAsesor()}}</span>
                                                <span class="mailbox-author">{{$articulacion->present()->articulacionPbtUserRolesAsesor()}} </span>
                                            </div>
                                        </div>
                                        <div class="right mailbox-buttons p-v-lg">
                                            <div class="right">
                                                <span class="mailbox-title">{{$articulacion->present()->articulacionPbtNodo()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12 m12 l12">
                                                <form id="frmUpdateArticulacionMiembros" action="{{route('articulacion.update.miembros', $articulacion->id)}}" method="POST" onsubmit="return checkSubmit()">
                                                    {!! method_field('PUT')!!}
                                                    {!! csrf_field() !!}
                                                    @include('articulacionespbt.form.form_miembros', ['btnText' => 'Modificar'])
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
    @include('articulacionespbt.modal.project-modal')
    @include('articulacionespbt.modal.talent-modal')
    @include('ideas.modals')
</main>
@endsection
@push('script')
  <script>
    datatableArchiveArticulacion_inicio();

    var Dropzone = new Dropzone('#fase_inicio_articulacion', {
        url: '{{ route('articulacion.files.upload', $articulacion->id) }}',
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
        url: "{{route('articulacion.files', [$articulacion->id, 'Inicio'])}}",
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

        {
            data: 'delete',
            name: 'delete',
            orderable: false,
        },

        ],
    });
    }
</script>
@endpush
