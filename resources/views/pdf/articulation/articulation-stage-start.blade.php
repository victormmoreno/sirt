@php
    $asesor = auth()->user();
@endphp
@extends('pdf.illustrated-layout')
@section('title-file', 'Acta de Inicio '. __('articulation-stage'))
@section('content-pdf')
<main class="card-content">
    <table class="bordered">
        <tr>
            <td colspan="1" rowspan="2"><img class="center-image" src="{{asset('img/web.png')}}"></td>
            <td colspan="5" class="centered"><b>Acta de Inicio<b></td>
        </tr>
        <tr>
            <td colspan="5" class="centered"><b>ACTA No. {{ substr($articulationStage->code, -4) . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}<b></td>
        </tr>
    </table>
    <br>
    <table class="bordered">
        <tr class="tr-striped">
            <td colspan="6" ><b>Información general<b></td>
        </tr>
        <tr>
            <td><b>{{__('Code articulation-stage')}}<b></td>
            <td colspan="3">{{$articulationStage->code}}</td>
            <td><b>{{__('ArticulationStage Type')}}</b></td>
            <td>{{$articulationStage->articulation_type}}</td>
        </tr>
        <tr>
            <td><b>{{__('Name articulation-stage')}}</b></td>
            <td colspan="5">{{$articulationStage->name}}</td>
        </tr>
        <tr>
            <td><b>{{__('Node')}}</b></td>
            <td colspan="2">{{$articulationStage->nodo}}</td>
            <td><b>{{__('Start Date')}}</b></td>
            <td colspan="2">{{$articulationStage->present()->articulationStageStartDate()}}</td>
        </tr>
        <tr>
            <td><b>{{__('Description')}}</b></td>
            <td colspan="5">{{$articulationStage->present()->articulationStageDescription()}}</td>
        </tr>
        <tr>
            <td><b>{{__('Scope')}}</b></td>
            <td colspan="5">{{$articulationStage->present()->articulationStageScope()}}</td>
        </tr>
        <tr>
            <td><b>Código Proyecto</b></td>
            <td colspan="2">{{$articulationStage->codigo_proyecto}}</td>
            <td><b>Nombre de proyecto</b></td>
            <td colspan="2">{{$articulationStage->nombre_proyecto}}</td>
        </tr>
        <tr>
            <td><b>Talento interlocutor</b></td>
            <td colspan="5">{{$articulationStage->documento}} - {{$articulationStage->nombres}} {{$articulationStage->apellidos}}</td>
        </tr>
        @if(isset($articulationStage->articulations) && $articulationStage->articulations->count() > 0)
        <tr class="tr-striped">
            <td colspan="6" ><b>Articulaciones<b></td>
        </tr>
        <tr class="tr-striped">
            <td><b>{{__('Code articulation-stage')}}<b></td>
            <td><b>{{__('Name articulation-stage')}}<b></td>
            <td><b>{{__('Phase')}}<b></td>
            <td><b>{{__('Start Date')}}<b></td>
            <td><b>{{__('End Date')}}<b></td>
            <td><b>{{__('Articulation Type')}} / {{__('articulation-subtype')}}<b></td>
        </tr>
        @forelse($articulationStage->articulations as $articulation)
            <tr>
                <td> <a href="{{route('articulations.show', $articulation)}}"
                    class="primary-text">{{$articulation->present()->articulationCode()}}</a></td>
                <td>{{$articulation->present()->articulationName()}}</td>
                <td>{{$articulation->present()->articulationPhase()}}</td>
                <td>{{$articulation->present()->articulationStartDate()}}</td>
                <td>{{$articulation->present()->articulationEndDate()}}</td>
                <td >{{$articulation->present()->articulationSubtype()}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No se encontraron resultados</td>
            </tr>
        @endforelse
        @endif
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
            <td colspan="6" >{{$articulationStage->documento}} - {{$articulationStage->nombres}} {{$articulationStage->apellidos}} - Talento Interlocutor</td>
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
