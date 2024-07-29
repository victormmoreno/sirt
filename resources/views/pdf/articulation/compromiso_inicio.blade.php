@extends('pdf.formato_compromiso')
@php
    $asesor = auth()->user();
@endphp
@section('title-file', 'Acta de inicio de proyecto')
@section('content-pdf')
<table>
    <tr>
        <td colspan="10" class="text-center">
            <b>ACTA NO. {{ $data->id . "-" . $request->txtfecha_reunion }}<b>
        </td>
    </tr>
    <tr>
        <td colspan="10">
            <b>NOMBRE DEL COMITÉ O DE LA REUNIÓN:</b> Acta de inicio de la articulación {{$data->code}} - {{$data->name}}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <b>CIUDAD Y FECHA:</b>
        </td>
        <td colspan="4">
            {{$data->node_city}} ({{$data->node_province}}) - {{$request->txtfecha_reunion}}
        </td>
        <td colspan="2" class="align-top">
            <b class="title">Hora inicio: </b>
            {{$request->txthora_inicio}}
        </td>
        <td colspan="2" class="align-top">
            <b class="title">Hora fin: </b>
            {{$request->txthora_fin}}
        </td>
    </tr>
    <tr>
        <td colspan="2" class="align-top">
            <b class="title">Lugar y/o enlace: </b>
        </td>
        <td colspan="4">
            Tecnoparque {{$data->nodo}} - {{$data->node_addresss}}
        </td>
        <td colspan="4">
            <b>DIRECCIÓN / REGIONAL / CENTRO: </b>
            Dirección de formación profesional / {{$data->node_province_name}} / {{$data->node_center}}
        </td>
    </tr>
    <tr>
        <td colspan="10">
            <b class="title">Agenda o puntos para desarrollar: </b>
            Elaborar acta de inicio y recolectar documentos de soporte de la articulación: {{$data->name}}
        </td>
    </tr>
    <tr>
        <td colspan="10">
            <b class="title">Objetivo(s) de la reunión: </b>
            Fijar el alcance, objetivo general y fecha esperada de finalización de la articulación: {{$data->name}}
        </td>
    </tr>
    <tr>
        <td colspan="10" class="text-center title">
            <b>DESARROLLO DE LA REUNIÓN</b>
        </td>
    </tr>
    <tr>
        <td colspan="10">
            <b>Código y nombre de la articulación: </b>{{$data->code}} - {{$data->name}}
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <b>Fecha de inicio de la articulación: </b>{{$data->present()->articulationStartDate()}}
        </td>
        <td colspan="4">
            <b>Alcance: </b>{{$data->present()->articulationScope()}}
        </td>
        <td colspan="3">
            <b>Tipo articulación / tipo subarticulación: </b>{{$data->present()->articulationSubtype()}}
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <b>{{__('Code articulation-stage')}}: </b>{{$data->articulation_stage_code}}
        </td>
        <td colspan="5">
            <b>{{__('ArticulationStage Type')}}: </b>{{$data->articulation_type}}
        </td>
    </tr>
    <tr>
        <td colspan="10"><b>{{__('Description')}}: </b>{{$data->present()->articulationDescription()}}</td>
    </tr>
    <tr>
        <td colspan="10"><b>{{__('Objetive')}}: </b>{{$data->present()->articulationObjetive()}}</td>
    </tr>
    <tr>
        <td colspan="3">
            <b>Entidad con la que se realiza la articulación: </b>{{$data->present()->articulationEntity()}}
        </td>
        <td colspan="4">
            <b>Nombre de contacto: </b>{{$data->present()->articulationContactName()}}
        </td>
        <td colspan="3">
            <b>Mail institucional: </b>{{$data->present()->articulationEmailEntity()}}
        </td>
    </tr>
    <tr>
        <td colspan="10" class="text-center title"><b>Conclusiones</b></td>
    </tr>
    <tr>
        <td colspan="10">
            Se fijan alcance y objetivos entre el talento y el articulador(a) participantes de la reunión.
        </td>
    </tr>
    <tr>
        <td colspan="10" class="text-center title"><b>Establecimiento y aceptación de compromisos</b></td>
    </tr>
    <tr class="text-center title">
        <td colspan="3" class="align-top">
            <b>Actividad / Decisión</b>
        </td>
        <td colspan="2" class="align-top">
            <b>Fecha</b>
        </td>
        <td colspan="2" class="align-top">
            <b>Responsable</b>
        </td>
        <td colspan="3" class="align-top">
            <b>Firma o participación virtual</b>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <p>
                1. Acompañar a talento en la recolección de información y procesos pertinentes para cumplir los requisitos de la postulación según el acompañamiento a ejecutar.
            </p>
            <p>
                2. Guardar confidencialidad y compromiso de la información susceptible del proyecto, la empresa y/o emprendimiento.
            </p>
        </td>
        <td colspan="2">
            {{$request->txtfecha_reunion}}
        </td>
        <td colspan="2">
            {{$asesor->nombres}} {{$asesor->apellidos}}
        </td>
        <td colspan="3">
            
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <p>
                1. Guardar confidencialidad y compromiso de la información susceptible del proyecto, la empresa y/o emprendimiento.
            </p>
            <p>
                2. Brindar la información necesaria para realizar seguimiento acompañamiento de la articulación y/o articulaciones.
            </p>
        </td>
        <td colspan="2">
            {{$request->txtfecha_reunion}}
        </td>
        <td colspan="2">
            {{$data->nombres}} {{$data->apellidos}}
        </td>
        <td colspan="3">
            
        </td>
    </tr>
    <tr>
        <td colspan="10" class="text-center title">
            <b>DE: ASISTENTES Y APROBACIÓN DE DECISIONES:</b>
        </td>
    </tr>
    <tr class="text-center">
        <th colspan="1">
            <b>NOMBRE</b>
        </th>
        <th colspan="2">
            <b>DEPENDENCIA / EMPRESA</b>
        </th>
        <th colspan="2">
            <b>APRUEBA (SI/NO)</b>
        </th>
        <th colspan="2">
            <b>OBSERVACIÓN</b>
        </th>
        <th colspan="3">
            <b>FIRMA O PARTICIPACIÓN VIRTUAL</b>
        </th>
    </tr>
    <tr>
        <td colspan="1">
            <b>{{$data->nombres}} {{$data->apellidos}}</b>
        </td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="1">
            <b>{{$asesor->nombres}} {{$asesor->apellidos}}</b>
        </td>
       <td colspan="2"></td>
       <td colspan="2"></td>
       <td colspan="2"></td>
       <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="10" class="text-justify no-wrap">
            De acuerdo con La Ley 1581 de 2012, Protección de Datos Personales, el Servicio Nacional de Aprendizaje SENA, se compromete a garantizar la seguridad y protección de los datos personales que se encuentran almacenados en este documento, y les dará el tratamiento correspondiente en cumplimiento de lo establecido legalmente.
        </td>
    </tr>
    <tr>
        <td colspan="10" class="title text-center align-top">
            <b>Anexos</b>
            NO APLICA
        </td>
    </tr>
</table>
@endsection