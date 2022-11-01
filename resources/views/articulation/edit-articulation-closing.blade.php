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
                    <li class="active">Cierre</li>
                </ol>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card mailbox-content">
                <div class="card-content">
                    <form id="articulation-form-closing" action="{{route('articulation.update', $articulation)}}" method="POST">
                        {!! method_field('PUT')!!}
                        @include('articulation.form.closing-form', ['btnText' => 'Modificar'])

                    </form>
                    <div class="row">
                        <!--@include('articulation.table-archive-phase', ['fase' => 'Cierre'])-->
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
            articulationClosing.checkedTypePostulacion();
            articulationClosing.checkedApproval();
        });

        let articulationClosing = {
            checkedTypePostulacion: function(){
                let postulation = $('input:radio[name=postulation]:checked').val();
                console.log(postulation);
                if (postulation == "yes") {
                    $(".r-si").show();
                    $(".r-no").hide();
                }else if(postulation == "no"){
                    $(".r-no").show();
                    $(".r-si").hide();
                }else{
                    $(".r-si").show();
                    $(".r-no").hide();
                }
            },
            checkedApproval: function(){
                let  approval = $('input:radio[name=approval]:checked').val();

                if (approval == "aprobado") {
                    $(".r-aprobado").show();
                    $(".r-no-aprobado").hide();
                }else if(approval == "noaprobado"){
                    $(".r-no-aprobado").show();
                    $(".r-aprobado").hide();
                }else{
                    $(".r-aprobado").show();
                    $(".r-no-aprobado").hide();
                }
            },
        }

        var Dropzone = new Dropzone('#articulation-closing-phase', {
            url: '{{ route('articulation.files.upload', [$articulation->id]) }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
            params: {
                type: "{{ basename(\App\Models\Articulation::class)}}",
                phase: 'Cierre'
            },
            paramName: 'nombreArchivo'
        });

        Dropzone.on('success', function (res) {
            //$('#archivosArticulacion').dataTable().fnDestroy();
            //datatableArchiveArticulacion_cierre();
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
            let msg = res.errors.nombreArchivo[0];
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

