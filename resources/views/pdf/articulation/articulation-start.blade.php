@php
    $asesor = auth()->user();
@endphp
@extends('pdf.illustrated-layout')
@section('title-file', 'Acta de Inicio '. __('articulation'))
@section('content-pdf')
<main class="card-content">
    <table class="bordered">
        <tr>
            <td colspan="1" rowspan="2"><img class="center-image" src="{{asset('img/web.png')}}"></td>
            <td colspan="5" class="centered"><b>Acta de Inicio<b></td>
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
            <td><b>{{__('Start Date')}}</b></td>
            <td>{{$articulation->present()->articulationStartDate()}}</td>
            <td><b>{{__('Scope')}}</b></td>
            <td>{{$articulation->present()->articulationScope()}}</td>
            <td><b>Tipo articulación / tipo subarticulación</b></td>
            <td>{{$articulation->present()->articulationSubtype()}}</td>
        </tr>
        <tr>
            <td><b>{{__('Code articulation-stage')}}<b></td>
            <td colspan="3">{{$articulation->articulation_stage_code}}</td>
            <td><b>{{__('ArticulationStage Type')}}</b></td>
            <td>{{$articulation->articulation_type}}</td>
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
        <tr>
            <td colspan="6"><b>El articulador se compromete a</b></td>
        </tr>
        <tr>
            <td colspan="6">
                <ul>
                    <li class="text-justify text-left">Acompañar a talento en la recolección de información y procesos pertinentes para cumplir los requisitos de la postulación según el acompañamiento a ejecutar.</li>
                    <li class="text-justify text-left">Guardar confidencialidad y compromiso de la información susceptible del proyecto, la empresa y/o emprendimiento.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td colspan="6"><b>El talento se compromete a</b></td>
        </tr>
        <tr>
            <td colspan="6">
                <ul>
                    <li class="text-justify text-left">Guardar confidencialidad y compromiso de la información susceptible del proyecto, la empresa y/o emprendimiento.</li>
                    <li class="text-justify text-left">Brindar la información necesaria para realizar seguimiento acompañamiento de la articulación y/o articulaciones.</li>
                </ul>
            </td>
        </tr>
        <tr class="tr-striped">
            <td colspan="6" ><b>Certificación del Talento Interlocutor y el Asesor<b></td>
        </tr>
        <tr>
            <td colspan="6" class="h-70p"></td>
        </tr>
        <tr>
            <td colspan="6" class="left">{{$articulation->documento}} - {{$articulation->nombres}} {{$articulation->apellidos}} - Talento Interlocutor</td>
        </tr>
        <tr>
            <td colspan="6" class="h-70p"></td>
        </tr>
        <tr>
            <td colspan="6" class="left">{{$asesor->documento}} -  {{$asesor->nombres}} {{$asesor->apellidos}} - Asesor</td>
        </tr>
    </table>
</main>
@endsection
