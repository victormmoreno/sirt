@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner">
    <div class="row content">
        <div class="row no-m-t no-m-b">
            <div class="left left-align">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">autorenew</i>{{__('articulation-stage')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                    <li ><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                    <li ><a href="{{route('articulation-stage.show',  $articulation->articulationstage)}}">{{ $articulation->articulationstage->present()->articulationStageCode() }}</a></li>
                    <li ><a href="{{route('articulations.show',  $articulation)}}">{{ $articulation->present()->articulationCode() }}</a></li>
                    <li class="active">Ejecución</li>
                </ol>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card mailbox-content">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <form id="articulation-execution-phase-form" action="{{route('articulation.update.execution', $articulation)}}" method="POST" onsubmit="return checkSubmit()">
                                @csrf
                                {!! method_field('PUT')!!}
                                <div>
                                    @include('articulation.form.execution-form', ['btnText' => 'Modificar'])
                                </div>
                                <div class="row">
                                    @include('articulation.table-archive-phase', ['fase' => 'ejecucion'])
                                </div>
                                <center>
                                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Guardar</button>
                                    <a href="{{ route('articulations.show', $articulation->id) }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
    <script>
        datatableArchiveArticulation();

        var Dropzone = new Dropzone('#articulation-execution-phase', {

            url: '{{ route('articulation.files.upload', [$articulation->id]) }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
            params: {
                type: "{{ basename(\App\Models\Articulation::class)}}",
                phase: 'Ejecución'
            },
            paramName: 'nombreArchivo'
        });

        Dropzone.on('success', function (res) {
            $('#archivesArticulations').dataTable().fnDestroy();
            datatableArchiveArticulation();
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

        function datatableArchiveArticulation() {
            $('#archivesArticulations').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                "ajax": {
                    "url": "{{route('articulation.files', [$articulation->id])}}",
                    "type": "get",
                    "data":{
                        type: "{{ basename(\App\Models\Articulation::class)}}",
                        phase: "Ejecución"
                    },
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


