@extends('pdf.formato_compromiso')
@section('title-file', 'Acta de inicio de proyecto')
@section('content-pdf')
<table>
    <tr>
        <td colspan="100" class="text-center">
            <b>ACTA NO. {{ $data->id . "-" . $request->txtfecha_reunion }}<b>
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b>NOMBRE DEL COMITÉ O DE LA REUNIÓN:</b> Acta de inicio del proyecto {{$data->codigo_proyecto}} - {{$data->nombre}}
        </td>
    </tr>
    <tr>
        <td colspan="20">
            <b>CIUDAD Y FECHA:</b>
        </td>
        <td colspan="46">
            {{$data->nodo->entidad->ciudad->nombre}} ({{$data->nodo->entidad->ciudad->departamento->nombre}}) - {{$request->txtfecha_reunion}}
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
            Tecnoparque {{$data->nodo->entidad->nombre}} - {{$data->nodo->direccion}}
        </td>
        <td colspan="34">
            <b>DIRECCIÓN / REGIONAL / CENTRO: </b>
            Dirección de formación profesional / {{$data->nodo->centro->regional->nombre}} / {{$data->nodo->centro->entidad->nombre}}
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b class="title">Agenda o puntos para desarrollar: </b>
            1. Caracterización del proyecto de acuerdo con los objetivos y alcance propuestos.
            2. Documentación que soportan el inicio del proyecto.
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b class="title">Objetivo(s) de la reunión: </b>
            Fijar el alcance, objetivo general y objetivos específicos del proyecto: {{$data->nombre}}
        </td>
    </tr>
    <tr>
        <td colspan="100" class="text-center title">
            <b>DESARROLLO DE LA REUNIÓN</b>
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b>Código y nombre de la Idea de Proyecto:</b> {{$data->idea->codigo_idea}} - {{$data->idea->datos_idea->nombre_proyecto->answer}}
        </td>
    </tr>
    <tr>
        <td colspan="50">
            <b>Área de conocimiento:</b> {{$data->present()->proyectoAreaConocimiento()}} 
            {{$data->present()->proyectoOtroAreaConocimiento()}}
        </td>
        <td colspan="50">
            <b>Sublínea:</b> {{$data->present()->proyectoSublinea()}}
        </td>
    </tr>
    <tr>
        <td colspan="40"><b>TRL que se pretende realizar:</b> {{$data->present()->proyectoTrlEsperado()}}</td>
        <td colspan="20"><b>¿Recibido a través de fábrica de productividad?:</b> {{$data->present()->proyectoFabricaProductividad()}}</td>
        <td colspan="40"><b>¿Recibido a través del área de emprendimiento SENA?:</b> {{$data->present()->proyectoRecibidoAreaEmprendimiento()}}</td>
    </tr>
    <tr>
        <td colspan="50">
            <b>¿El proyecto está dirigido a personas en condición de discapacidad?:</b> {{$data->present()->proyectoDirigidoDiscapacitados()}}
            @if ($data->dirigido_discapacitados == 1)
            <br>
            <b>Tipo de discapacidad:</b> {{$data->present()->proyectoDirigidoTipoDiscapacitados()}}
            @endif
        </td>
        <td colspan="50">
            <b>Articulado con CT+i:</b> {{$data->present()->proyectoActorCTi()}}
            @if ($data->art_cti == 1)
            <br>
            <b>Nombre del Actor CT+i:</b> {{$data->present()->proyectoNombreActorCTi()}}
            @endif
        </td>
    </tr>
    <tr class="text-center">
        <td colspan="100"><b>TALENTOS QUE PARTICIPAN EN EL PROYECTO<b></td>
    </tr>
    <tr>
        <td colspan="20"><b>Interlocutor</b></td>
        <td colspan="80"><b>Talento</b></td>
    </tr>
    @forelse ($data->talentos as $talento)
        <tr>
            @if($talento->pivot->talento_lider == 1)
                <td colspan="20">SI</td>
            @else
            <td colspan="20">NO</td>
            @endif
            <td colspan="80" >{{$talento->present()->userFullName()}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="20" >Sin resultados</td>
            <td colspan="80" >Sin resultados</td>
        </tr>
    @endforelse
    <tr class="text-center">
        <td colspan="100"><b>OBJETIVOS DEL PROYECTO Y ALCANCE<b></td>
    </tr>
    <tr>
        <td colspan="100"><b>OBJETIVO GENERAL: </b>{{$data->present()->proyectoObjetivoGeneral()}}
        </td>
    </tr>
    <tr class="text-center">
        <td  colspan="100"><b>OBJETIVOS ESPECÍFICOS</b></td>
    </tr>
    <tr>
        <td colspan="10" class="text-center"><b>1</b></td>
        <td colspan="90">{{$data->present()->proyectoPrimerObjetivo()}}</td>
    </tr>
    <tr>
        <td colspan="10" class="text-center"><b>2</b></td>
        <td colspan="90">{{$data->present()->proyectoSegundoObjetivo()}}</td>
    </tr>
    <tr>
        <td colspan="10" class="text-center"><b>3</b></td>
        <td colspan="90">{{$data->present()->proyectoTercerObjetivo()}}</td>
    </tr>
    <tr>
        <td colspan="10" class="text-center"><b>4</b></td>
        <td colspan="90">{{$data->present()->proyectoCuartoObjetivo()}}</td>
    </tr>
    <tr>
        <td colspan="100">
            <b>ALCANCE DEL PROYECTO:</b> {{$data->present()->proyectoAlcance()}}
        </td>
    </tr>
    <tr class="text-center">
        <td colspan="100"><b>DATOS DE LA PROPIEDAD INTELECTUAL<b></td>
    </tr>
    <tr class="text-center">
        <td colspan="100"><b>PERSONAS (TALENTOS)</b></td>
    </tr>
    @if ($data->users_propietarios->count() > 0)
        @foreach ($data->users_propietarios as $key => $value)
            <tr>
                <td colspan="100">{{$value->nombres}} {{$value->apellidos}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="100">No se encontraron personas dueñas de la propiedad intelectual.</td>
        </tr>
    @endif
    <tr class="text-center">
        <td colspan="100"><b>EMPRESAS</b></td>
    </tr>
    @if ($data->sedes->count() > 0)
        <tr>
            <td colspan="20"><b>Nit</b></td>
            <td colspan="80"><b>Nombre de empresa</b></td>
        </tr>
        @foreach ($data->sedes as $key => $value)
            <tr>
                <td colspan="20">{{$value->empresa->nit}}</td>
                <td colspan="80">{{ $value->empresa->nombre }} ({{ $value->nombre_sede }})</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="100">No se encontraron personas dueñas de la propiedad intelectual.</td>
        </tr>
    @endif
    <tr class="text-center">
        <td colspan="100"><b>GRUPOS DE INVESTIGACIÓN</b></td>
    </tr>
    @if ($data->gruposinvestigacion->count() > 0)
        <tr>
            <td colspan="20"><b>Código grupo</b></td>
            <td colspan="80"><b>Grupo de investigación</b></td>
        </tr>
        @foreach ($data->gruposinvestigacion as $key => $value)
            <tr>
                <td colspan="20">{{$value->codigo_grupo}}</td>
                <td colspan="80">{{ $value->entidad->nombre }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="100">No se encontraron personas dueñas de la propiedad intelectual.</td>
        </tr>
    @endif
    <tr>
        <td colspan="100" class="text-center title"><b>Conclusiones</b></td>
    </tr>
    <tr>
        <td colspan="100">
            Se fijan alcance y objetivos entre el talento y experto participantes de la reunión.
        </td>
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
    <tr class="text-center title">
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
            <b>{{$data->present()->talentoInterlocutor()}}</b>
        </td>
        <td colspan="20"></td>
        <td colspan="20"></td>
        <td colspan="20"></td>
        <td colspan="20"></td>
    </tr>
    <tr>
        <td colspan="20">
            <b>{{$data->present()->proyectoUserAsesor()}}</b>
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