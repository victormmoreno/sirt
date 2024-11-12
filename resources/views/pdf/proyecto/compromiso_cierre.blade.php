@extends('pdf.formato_compromiso')
@section('title-file', 'Acta de cierre de proyecto ' . $data->codigo_proyecto)
@section('content-pdf')
<table>
    <tr>
        <td colspan="100" class="text-center">
            <b>ACTA NO. {{ $data->id . "-" . $request->txtfecha_reunion }}<b>
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b>NOMBRE DEL COMITÉ O DE LA REUNIÓN:</b> Acta de cierre del proyecto {{$data->codigo_proyecto}} - {{$data->nombre}}
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
            1. Revisión de los objetivos del proyecto.
            2. Revisión de los entregables y resultados.
            3. Aprobación formal del cierre del proyecto.
            4. Conclusiones y cierre de la reunión.
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b class="title">Objetivo(s) de la reunión: </b>
            Dar por finalizada la ejecución del proyecto {{$data->nombre}}, revisando los objetivos alcanzados, 
            entregables, desempeño, y obtener la aprobación formal del cierre del proyecto.
        </td>
    </tr>
    <tr>
        <td colspan="100" class="text-center title">
            <b>Desarrollo de la reunión</b>
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b>Código y nombre de la idea de proyecto:</b> {{$data->idea->codigo_idea}} - {{$data->idea->datos_idea->nombre_proyecto->answer}}
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
        <td colspan="30">
            @if ($data->trl_obtenido == 0)
            <b>TRL obtenido: </b>TRL 6
            @elseif($data->trl_obtenido == 1)
            <b>TRL obtenido: </b>TRL 7
            @else
            <b>TRL obtenido: </b>TRL 8
            @endif
        </td>
        <td colspan="40">
            <b>¿Dirigido al área de emprendimiento SENA?:</b> {{$data->diri_ar_emp == 0 ? 'NO' : 'SI'}}
        </td>
        <td colspan="30">
            <b>Aporte estimado de Tecnoparque al proyecto:</b> {{asMoney($costo->getData()->costosTotales)}}</span>
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
    <tr class="text-center title">
        <td colspan="100"><b>OBJETIVOS ESPECÍFICOS DEL PROYECTO</b></td>
    </tr>
    <tr>
        <td colspan="80"><b>Objetivo</b></td>
        <td colspan="20"><b>¿Se cumplió?</b></td>
    </tr>
    <tr>
        <td colspan="80">{{ $data->present()->proyectoPrimerObjetivo() }}</td>
        <td colspan="20">{{ $data->present()->isProyectoCumplioPrimerObjetivo() }}</td>
    </tr>
    <tr>
        <td colspan="80">{{ $data->present()->proyectoSegundoObjetivo() }}</td>
        <td colspan="20">{{ $data->present()->isProyectoCumplioSegundoObjetivo()}}</td>
    </tr>
    <tr>
        <td colspan="80">{{ $data->present()->proyectoTercerObjetivo() }}</td>
        <td colspan="20">{{ $data->present()->isProyectoCumplioTercerObjetivo() }}</td>
    </tr>
    <tr>
        <td colspan="80">{{ $data->present()->proyectoCuartoObjetivo() }}</td>
        <td colspan="20">{{ $data->present()->isProyectoCumplioCuartoObjetivo() }}</td>
    </tr>
    <tr class="text-center title">
        <td colspan="100"><b>Evidencias TRL</b></td>
    </tr>
    <tr>
        <td colspan="100">
            <b>EVIDENCIAS DE PROTOTIPO DEL PRODUCTO: </b>{{$data->present()->proyectoTrlPrototipo()}}
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b>EVIDENCIAS DE PRUEBAS DOCUMENTADAS: </b>{{$data->present()->proyectoEvidenciasPruebasDocumentadas()}}
        </td>
    </tr>
    <tr>
        <td colspan="100">
            <b>EVIDENCIAS DE MODELO DE NEGOCIO: </b>{{$data->present()->proyectoEvidenciasModeloNegocio()}}
        </td>
    </tr>
    <tr>
        <td colspan="100"><b>EVIDENCIAS DE NORMATIVIDAD: </b>{{$data->present()->proyectoEvidenciasNormatividad()}}</td>
    </tr>
    <tr>
        <td colspan="100" class="text-center title"><b>Conclusiones y siguiente paso del proyecto</b></td>
    </tr>
    <tr>
        <td colspan="100">
            {{$data->conclusiones}}
        </td>
    </tr>
    <tr>
        <td colspan="100" class="text-center title"><b>Conclusiones</b></td>
    </tr>
    <tr>
        <td colspan="100">
            Se resumieron los puntos principales discutidos. <br>
            {{$data->present()->talentoInterlocutor()}} declaró formalmente cerrado el proyecto.
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