@extends('pdf.formato_compromiso')
@section('title-file', 'Acta de cierre de articulación')
@php
    $asesor = auth()->user();
@endphp
@section('content-pdf')
<table>
    <tr>
        <td colspan="100" class="text-center">
            <b>ACTA NO. {{ $data->id . "-" . $request->txtfecha_reunion }}<b>
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b>NOMBRE DEL COMITÉ O DE LA REUNIÓN:</b> Acta de cierre de la articulación {{$data->code}} - {{$data->name}}
        </td>
    </tr>
    <tr>
        <td colspan="20">
            <b>CIUDAD Y FECHA:</b>
        </td>
        <td colspan="46">
            {{$data->node_city}} ({{$data->node_province}}) - {{$request->txtfecha_reunion}}
        </td>
        <td colspan="17" class="align-top">
            <b class="title">Hora inicio: </b>
            {{$request->txthora_inicio}}
        </td>
        <td colspan="17" class="align-top">
            <b class="title">Hora fin: </b>
            {{$request->txthora_fin}}
        </td>
    </tr>
    <tr>
        <td colspan="20" class="align-top">
            <b class="title">Lugar y/o enlace: </b>
        </td>
        <td colspan="46">
            Tecnoparque {{$data->nodo}} - {{$data->node_addresss}}
        </td>
        <td colspan="34">
            <b>DIRECCIÓN / REGIONAL / CENTRO: </b>
            Dirección de formación profesional / {{$data->node_province_name}} / {{$data->node_center}}
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b class="title">Agenda o puntos para desarrollar: </b>
            1. Revisión del cumplimiento del objetivo de la articulación.
            2. Revisión de la disponibilidad de los entregables y cumplimiento de resultados.
            3. Lecciones aprendidas.
            4. Aprobación formal del cierre de la articulación.
            5. Conclusiones y cierre de la reunión.
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b class="title">Objetivo(s) de la reunión: </b>
            Dar por finalizada la ejecución de la articulación {{$data->name}}, revisando el objetivo alcanzado, 
            entregables, y obtener la aprobación formal del cierre de la articulación.
        </td>
    </tr>
    <tr>
        <td colspan="100" class="text-center title">
            <b>Desarrollo de la reunión</b>
        </td>
    </tr>
    <tr>
        <td colspan="48">
            <b>Código y nombre de la articulación: </b> {{$data->code}} - {{$data->name}}
        </td>
        <td colspan="52">
            <b>{{__('Node')}}: </b>{{$data->nodo}}
        </td>
    </tr>
    <tr>
        <td colspan="48"><b>{{__('Code articulation-stage')}}: </b>{{$data->articulation_stage_code}}</td>
        <td colspan="52"><b>{{__('ArticulationStage Type')}}: </b>{{$data->articulation_type}}</td>
    </tr>
    <tr>
        <td colspan="30">
            <b>Fecha de inicio de la articulación: </b>{{$data->present()->articulationStartDate()}}
        </td>
        <td colspan="40">
            <b>Alcance: </b>{{$data->present()->articulationScope()}}
        </td>
        <td colspan="30">
            <b>Tipo articulación / tipo subarticulación: </b>{{$data->present()->articulationSubtype()}}
        </td>
    </tr>
    <tr>
        <td colspan="100"><b>{{__('Description')}}: </b>{{$data->present()->articulationDescription()}}</td>
    </tr>
    <tr>
        <td colspan="100"><b>{{__('Objetive')}}: </b>{{$data->present()->articulationObjetive()}}</td>
    </tr>
    <tr>
        <td colspan="30">
            <b>Entidad con la que se realiza la articulación: </b>{{$data->present()->articulationEntity()}}
        </td>
        <td colspan="40">
            <b>Nombre de contacto: </b>{{$data->present()->articulationContactName()}}
        </td>
        <td colspan="30">
            <b>Mail institucional: </b>{{$data->present()->articulationEmailEntity()}}
        </td>
    </tr>
    @if ($data->postulation == 0)
        <tr>
            <td colspan="20"><b>Se realizo la postulación al convenio, convocatoria y/o instrumento</b> {{$data->postulation == 0 ? 'NO': 'SI' }}</td>
            <td colspan="80"><b>Justificación: </b>{{ isset($data->justification) ? $data->justification : 'No registra'}}</td>
        </tr>
    @else
        <tr>
            <td colspan="50">
                <b>Se realizo la postulación al convenio, convocatoria y/o instrumento: </b>{{$data->postulation == 0 ? 'NO': 'SI' }}
            </td>
            <td colspan="50">
                <b>¿Aprobación?: </b>{{$data->approval == 1 ? 'Aprobado': 'No aprobado' }}
            </td>
        </tr>
        @if ($data->approval == 1)
            <tr>
                <td colspan="50">
                    <b>Qué recibirá: </b>{{isset($data->receive) ? $data->receive : ''}}
                </td>
                <td colspan="50">
                    <b>Cuando: </b>{{isset($data) ? optional($data->received_date)->format('Y-m-d') : ''}}
                </td>
            </tr>
            @else
            <tr>
                <td colspan="100"><b>Informe: </b>{{isset($data) ? $data->report: '' }}</td>
            </tr>
        @endif
    @endif
    <tr>
        <td colspan="100"><b>Lecciones aprendidas: </b>{{isset($data) ? $data->learned_lessons : '' }}</td>
    </tr>
    <tr>
        <td colspan="100" class="text-center title"><b>Establecimiento y aceptación de compromisos</b></td>
    </tr>
    <tr class="text-center title">
        <td colspan="25" class="align-top">
            <b>Actividad / Decisión</b>
        </td>
        <td colspan="25" class="align-top">
            <b>Fecha</b>
        </td>
        <td colspan="25" class="align-top">
            <b>Responsable</b>
        </td>
        <td colspan="25" class="align-top">
            <b>Firma o participación virtual</b>
        </td>
    </tr>
    <tr>
        <td colspan="25">
            NO APLICA
        </td>
        <td colspan="25">
            NO APLICA
        </td>
        <td colspan="25">
            NO APLICA
        </td>
        <td colspan="25">
            NO APLICA
        </td>
    </tr>
    <tr>
        <td colspan="100" class="text-center title">
            <b>DE: ASISTENTES Y APROBACIÓN DE DECISIONES:</b>
        </td>
    </tr>
    <tr class="text-center">
        <th colspan="20">
            <b>NOMBRE</b>
        </th>
        <th colspan="20">
            <b>DEPENDENCIA / EMPRESA</b>
        </th>
        <th colspan="20">
            <b>APRUEBA (SI/NO)</b>
        </th>
        <th colspan="20">
            <b>OBSERVACIÓN</b>
        </th>
        <th colspan="20">
            <b>FIRMA O PARTICIPACIÓN VIRTUAL</b>
        </th>
    </tr>
    <tr>
        <td colspan="20">
            <b>{{$data->nombres}} {{$data->apellidos}}</b>
        </td>
        <td colspan="20"></td>
        <td colspan="20"></td>
        <td colspan="20"></td>
        <td colspan="20"></td>
    </tr>
    <tr>
        <td colspan="20">
            <b>{{$asesor->nombres}} {{$asesor->apellidos}}</b>
        </td>
       <td colspan="20"></td>
       <td colspan="20"></td>
       <td colspan="20"></td>
       <td colspan="20"></td>
    </tr>
    <tr>
        <td colspan="100" class="text-justify no-wrap">
            De acuerdo con La Ley 1581 de 2012, Protección de Datos Personales, el Servicio Nacional de Aprendizaje SENA, se compromete a garantizar la seguridad y protección de los datos personales que se encuentran almacenados en este documento, y les dará el tratamiento correspondiente en cumplimiento de lo establecido legalmente.
        </td>
    </tr>
    <tr>
        <td colspan="100" class="title text-center align-top">
            <b>Anexos</b>
            NO APLICA
        </td>
    </tr>
</table>
@endsection