@php
    $asesor = auth()->user();
@endphp
@extends('pdf.illustrated-layout')
@section('title-file', 'Acta de Cierre '. __('articulation'))
@section('content-pdf')
<main class="card-content">
    <table class="bordered">
        <tr>
            <td colspan="1" rowspan="2"><img class="center-image" src="{{asset('img/web.png')}}"></td>
            <td colspan="5" class="centered"><b>Acta de Cierre<b></td>
        </tr>
        <tr>
            <td colspan="5" class="centered"><b>ACTA No. {{ substr($articulation->code, -4) . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}<b></td>
        </tr>
    </table>
    <br>
    <table class="bordered">
        <tr class="tr-striped">
            <td colspan="6" ><b>Información general<b></td>
        </tr>
        <tr>
            <td><b>{{__('Code articulation')}}<b></td>
            <td colspan="3">{{$articulation->code}}</td>
            <td><b>{{__('Node')}}</b></td>
            <td>{{$articulation->nodo}}</td>
        </tr>
        <tr>
            <td><b>{{__('Name articulation')}}</b></td>
            <td colspan="5">{{$articulation->name}}</td>
        </tr>
        <tr>
            <td><b>{{__('Code articulation-stage')}}<b></td>
            <td colspan="3">{{$articulation->articulation_stage_code}}</td>
            <td><b>{{__('ArticulationStage Type')}}</b></td>
            <td>{{$articulation->articulation_type}}</td>
        </tr>
        <tr>
            <td><b>{{__('Start Date')}}</b></td>
            <td>{{$articulation->present()->articulationStartDate()}}</td>
            <td><b>{{__('Scope')}}</b></td>
            <td>{{$articulation->present()->articulationScope()}}</td>
            <td><b>Tipo articulación / tipo subarticulación</b></td>
            <td>{{$articulation->present()->articulationSubtype()}}</td>
        </tr>
        <tr>
            <td><b>{{__('Description')}}</b></td>
            <td colspan="5">{{$articulation->present()->articulationDescription()}}</td>
        </tr>
        <tr>
            <td><b>{{__('Objetive')}}</b></td>
            <td colspan="5">{{$articulation->present()->articulationObjetive()}}</td>
        </tr>
        <tr>
            <td><b> Entidad con la que se realiza la articulación</b></td>
            <td>{{$articulation->present()->articulationEntity()}}</td>
            <td><b>Nombre de contacto</b></td>
            <td>{{$articulation->present()->articulationContactName()}}</td>
            <td><b>Mail institucional</b></td>
            <td>{{$articulation->present()->articulationEmailEntity()}}</td>
        </tr>

        @if ($articulation->postulation == 0)

            <tr>
                <td colspan="2"><b>Se realizo la postulación al convenio, convocatoria y/o instrumento</b> {{$articulation->postulation == 0 ? 'NO': 'SI' }}</td>

                <td><b>Justificación</b></td>
                <td colspan="3">{{ isset($articulation->justification) ? $articulation->justification : 'No registra'}}</td>
            </tr>
        @else
            <tr>
                <td colspan="3"><b>Se realizo la postulación al convenio, convocatoria y/o instrumento</b></td>
                <td>{{$articulation->postulation == 0 ? 'NO': 'SI' }}</td>
                <td><b>¿Aprobación?</b><td>{{$articulation->approval == 1 ? 'Aprobado': 'No aprobado' }}</td></td>
            </tr>
            @if ($articulation->approval == 1)
                <tr>
                    <td><b>Qué recibirá</b></td>
                    <td colspan="3">{{isset($articulation->receive) ? $articulation->receive : ''}}</td>
                    <td ><b>Cuando</b></td>
                    <td>{{isset($articulation) ? optional($articulation->received_date)->format('Y-m-d') : ''}}</td>
                </tr>
                @else
                <tr >
                    <td><p>Informe</p></td>
                    <td colspan="5">
                        {{isset($articulation) ? $articulation->report: '' }}
                    </td>
                </tr>
            @endif
        @endif
        <tr>
            <td><b>Lecciones aprendidas</b></td>
            <td colspan="5">{{isset($articulation) ? $articulation->learned_lessons : '' }}</td>
        </tr>
        <tr>
            <td><b>Código Proyecto</b></td>
            <td colspan="2">{{$articulation->codigo_proyecto}}</td>
            <td><b>Nombre de proyecto</b></td>
            <td colspan="2">{{$articulation->nombre_proyecto}}</td>
        </tr>
        <tr>
            <td><b>Talento interlocutor</b></td>
            <td colspan="5">{{$articulation->documento}} - {{$articulation->nombres}} {{$articulation->apellidos}}</td>
        </tr>
        <tr class="tr-striped">
            <td colspan="6" ><b>Certificación del Talento Interlocutor y el Asesor<b></td>
        </tr>
        <tr>
            <td colspan="6" class="h-70p"></td>
        </tr>
        <tr>
            <td colspan="6" >{{$articulation->documento}} - {{$articulation->nombres}} {{$articulation->apellidos}} - Talento Interlocutor</td>
        </tr>
        <tr>
            <td colspan="6" class="h-70p"></td>
        </tr>
        <tr>
            <td colspan="6" >{{$asesor->documento}} -  {{$asesor->nombres}} {{$asesor->apellidos}} - Asesor</td>
        </tr>
    </table>
</main>
@endsection
