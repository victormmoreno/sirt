@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('content')
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s8 m8 l5">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">
                        autorenew
                    </i>
                    Articulaciones
                </h5>
            </div>
            <div class="col s4 m4 l5 offset-l2  rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li ><a href="{{route('articulaciones.index')}}">Articulaciones</a></li>
                    <li class="active">detalle</li>
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
                                        @can('reversePhase', $articulacion)
                                        <div class="mailbox-view-header no-m-b no-m-t">
                                            <div class="right mailbox-buttons no-s">
                                                <form action="{{route('articulacion.reversar', [$articulacion->id, 'Inicio'])}}" method="POST" name="frmReversarFase">
                                                    {!! method_field('PUT')!!}
                                                    @csrf
                                                    <button type="submit" onclick="preguntaReversarArticulacion(event)" value="send" class="btn-flat">
                                                        Reversar fase de la articulación a Inicio.
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @endcan
                                        @can('permissionsOptions', $articulacion)
                                            <div class="mailbox-view-header no-m-b no-m-t">
                                                <div class="right mailbox-buttons no-s">
                                                    @if($articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio()))
                                                        <a href="{{route('articulacion.show.inicio',$articulacion->id)}}" class="waves-effect waves-orange btn orange m-t-xs">Ir a la Fase de  {{$articulacion->present()->articulacionPbtNameFase()}}</a>
                                                    @elseif($articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsEjecucion()))
                                                        <a href="{{route('articulacion.show.ejecucion',$articulacion->id)}}" class="waves-effect waves-orange btn orange m-t-xs">Ir a la Fase de {{$articulacion->present()->articulacionPbtNameFase()}}</a>
                                                    @elseif($articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsCierre()))
                                                        <a href="{{route('articulacion.show.cierre',$articulacion->id)}}" class="waves-effect waves-orange btn orange m-t-xs">Ir a la Fase de {{$articulacion->present()->articulacionPbtNameFase()}}</a>
                                                    @endif
                                                    @can('changeAsesor', $articulacion)
                                                        <a href="{{route('articulacion.cambiar',$articulacion->id)}}" class="waves-effect waves-grey btn-flat m-t-xs">Cambiar articulador</a>
                                                    @endcan
                                                    @can('updateMiembros', $articulacion)
                                                    <a href="{{route('articulacion.miembros', $articulacion->id)}}" class="waves-effect waves-grey btn-flat m-t-xs">Miembros</a>
                                                    @endcan
                                                    @can('suspender', $articulacion)
                                                    <a href="{{route('articulacion.suspender', $articulacion->id)}}" class="waves-effect waves-grey btn-flat m-t-xs">Suspender Articulación</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        @endcan
                                    <div class="mailbox-view-header">
                                        <div class="left">
                                            <span class="mailbox-title p-v-lg">{{$articulacion->present()->articulacionPbtCode()}} - {{$articulacion->present()->articulacionPbtName()}}</span>
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
                                            <div class="col s12">
                                                @include('articulacionespbt.history-change')
                                            </div>
                                            <div class="col s12">
                                                <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                                                    <li class="tab col s3"><a href="#faseinicio" class="active">Inicio</a></li>
                                                    <li class="tab col s3"><a class="" href="#faseejecucion">Ejecución</a></li>
                                                    <li class="tab col s3"><a href="#fasecierre" class="">Cierre</a></li>
                                                <div class="indicator" style="right: 281.25px; left: 0px;"></div></ul>
                                            </div>
                                            <div id="faseinicio" class="col s12" style="display: block;">
                                                @include('articulacionespbt.detail.detail-fase-inicio')
                                            </div>
                                            <div id="faseejecucion" class="col s12" style="display: none;">
                                                @include('articulacionespbt.detail.detail-fase-ejecucion')
                                            </div>
                                            <div id="fasecierre" class="col s12" style="display: none;">
                                                @include('articulacionespbt.detail.detail-fase-cierre')
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
    datatableArchivosArticulacionInicio();
    datatableArchivosArticulacionEjecucion();
    datatableArchivosArticulacionCierre();
    function datatableArchivosArticulacionInicio() {
        $('.inicio').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            "lengthChange": false,
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
            ],
        });
    }

    function datatableArchivosArticulacionEjecucion() {
        $('.ejecucion').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            "lengthChange": false,
            ajax:{
            url: "{{route('articulacion.files', [$articulacion->id, 'Ejecución'])}}",
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

    function datatableArchivosArticulacionCierre() {
        $('.cierre').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            "lengthChange": false,
            ajax:{
            url: "{{route('articulacion.files', [$articulacion->id,'Cierre'])}}",
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
