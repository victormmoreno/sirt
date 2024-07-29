<!doctype html>
<html lang="en">
<head>
    <style>
        footer.page-footer {
            margin-top: 20px;
            padding-top: 20px;
            background-color: #ee6e73;
        }

        footer.page-footer .footer-copyright {
            overflow: hidden;
            height: 50px;
            line-height: 50px;
            color: rgba(255, 255, 255, 0.8);
            background-color: rgba(51, 51, 51, 0.08);
        }

        .center-image{
            vertical-align: middle;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-left: 10px;

        }

        table, th, td {
            border: solid;
        }

        table {
            width: 100%;
            display: table;
            font-size: 13px;
            word-wrap: break-word;
        }

        table.bordered > thead > tr,
        table.bordered > tbody > tr {
            border-bottom: 2px solid #050505;
        }

        table.striped > tbody > tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        table.striped > tbody > tr > td {
            border-radius: 0;
        }

        table.highlight > tbody > tr {
            transition: background-color .25s ease;
        }

        table.highlight > tbody > tr:hover {
            background-color: #f2f2f2;
        }

        table.centered thead tr th, table.centered tbody tr td {
            text-align: center;
        }

        thead {
            border-bottom: 1px solid #d0d0d0;
        }
        td, th {
            display: table-cell;
            text-align: left;
            vertical-align: middle;
            border-radius: 2px;
            overflow: hidden;
            white-space: pre-line;
        }
        .centered {
            text-align: center;
        }
        .left {
            text-align: left;
        }
    @media only screen and (max-width: 992px) {
        table.responsive-table thead {
            border: 0;
            border-right: 1px solid #d0d0d0;
        }
        table.responsive-table.bordered th {
            border-bottom: 0;
            border-left: 0;

        }
        table.responsive-table.bordered td {
            border-left: 0;
            border-right: 0;
            border-bottom: 0;
            border: 1px solid #000;
        }
        table.responsive-table.bordered tr {
            border: 0;
        }
        table.responsive-table.bordered tbody tr {
            border-right: 1px solid #d0d0d0;
            min-width: 235px;
            height: 10px;
            background-color: #433;
        }

        td{
            text-align: center;
        padding: 5px;
        /* Alto de las celdas */
        height: 10px;
        }

        .tr-striped {
            background-color: #bdbdbd;
            }
        }
        footer {
            position: fixed;
            bottom: -1cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            background-color: white;
            color: black;
            text-align: center;
            line-height: 35px;
        }
        </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <title>Acta de Inicio</title>
</head>
<body>
    <footer>
        GD-F-007 V01
    </footer>
    <div class="card-content">
        <table class="bordered">
            <tr>
                <td colspan="1" rowspan="2"><img class="center-image" src="{{asset('img/web.png')}}"></td>
                <td colspan="5" class="centered"><b>Acta de Inicio<b></td>
            </tr>
            <tr>
                <td colspan="5" class="centered"><b>ACTA No. {{ substr($proyecto->present()->proyectoCode(), -4) . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}<b></td>
            </tr>
        </table>
        <br>
        <table class="bordered">
            <tr>
                <td  scope="row" colspan="6"><b>TÍTULO DE PROYECTO: {{$proyecto->present()->proyectoName()}}</b></td>
            </tr>
            <tr>
                <td colspan="1" scope="row">Nodo: <b>{{$proyecto->present()->proyectoNode()}}</b></td>
                <td colspan="2">Fecha: <b>{{$proyecto->present()->proyectoFechaInicio()}}</b></td>
                <td colspan="3">Código del Proyecto: <b>{{$proyecto->present()->proyectoCode()}}</b></td>
            </tr>
            <tr class="tr-striped">
                <td colspan="6" ><b>DATOS DEL PROYECTO<b></td>
            </tr>
            <tr>
                <td colspan="3">Código de la Idea de Proyecto: <b>{{$proyecto->idea->present()->ideaCode()}}</b></td>
                <td colspan="3">Nombre de la Idea de Proyecto: <b>{{$proyecto->idea->present()->ideaName()}}</b></td>
            </tr>
            <tr>
                <td colspan="3">
                    Área de conocimiento: <b>{{$proyecto->present()->proyectoAreaConocimiento()}}</b>
                    <br>
                    {{$proyecto->present()->proyectoOtroAreaConocimiento()}}
                </td>
                <td colspan="3">Sublínea: <b>{{$proyecto->present()->proyectoSublinea()}}</b></td>
            </tr>
            <tr>
                <td colspan="2">TRL que se pretende realizar: <b>{{$proyecto->present()->proyectoTrlEsperado()}}</b></td>
                <td colspan="2">¿Recibido a través de fábrica de productividad?: <b>{{$proyecto->present()->proyectoFabricaProductividad()}}</b></td>
                <td colspan="2">¿Recibido a través del área de emprendimiento SENA?: <b>{{$proyecto->present()->proyectoRecibidoAreaEmprendimiento()}}</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    ¿El proyecto pertenece a la economía naranja?: <b>{{$proyecto->present()->proyectoEconomiaNaranja()}}</b>
                    @if ($proyecto->economia_naranja == 1)
                    <br>
                    Tipo de economía naranja: <b>{{$proyecto->present()->proyectoTipoEconomiaNaranja()}}</b>
                    @endif
                </td>
                <td colspan="2">
                    ¿El proyecto está dirigido a personas en condición de discapacidad?: <b>{{$proyecto->present()->proyectoDirigidoDiscapacitados()}}</b>
                    @if ($proyecto->dirigido_discapacitados == 1)
                    <br>
                    Tipo de discapacidad: <b>{{$proyecto->present()->proyectoDirigidoTipoDiscapacitados()}}</b></p>
                    @endif
                </td>
                <td colspan="2">
                    Articulado con CT+i: <b>{{$proyecto->present()->proyectoActorCTi()}}</b>
                    @if ($proyecto->art_cti == 1)
                    <br>
                    Nombre del Actor CT+i: <b>{{$proyecto->present()->proyectoNombreActorCTi()}}</b>
                    @endif
                </td>
            </tr>
            <tr class="tr-striped">
                <td colspan="6" ><b>TALENTOS QUE PARTICIPAN EN EL PROYECTO<b></td>
            </tr>
            <tr>
                <td colspan="1"><b>Interlocutor</b></td>
                <td colspan="5"><b>Talento</b></td>
            </tr>
            @forelse ($proyecto->talentos as $talento)
            <tr>
                @if($talento->pivot->talento_lider == 1)
                    <td colspan="1" >SI</td>
                @else
                <td colspan="1" >NO</td>
                @endif
                <td colspan="5" >{{$talento->present()->userDocumento()}} - {{$talento->present()->userFullName()}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="1" >Sin resultados</td>
                <td colspan="5" >Sin resultados</td>
            </tr>
            @endforelse
            <tr class="tr-striped">
                <td colspan="6" ><b>OBJETIVOS DEL PROYECTO Y ALCANCE<b></td>
            </tr>
            <tr>
                <td colspan="1"><b>OBJETIVO GENERAL</b></td>
                <td colspan="5">
                    {{$proyecto->present()->proyectoObjetivoGeneral()}}
                </td>
            </tr>
            <tr class="tr-striped">
                <td  colspan="6"><b>OBJETIVOS ESPECÍFICOS</b></td>
            </tr>
            <tr>
                <td colspan="1"><b>1</b></td>
                <td colspan="5">{{$proyecto->present()->proyectoPrimerObjetivo()}}</td>
            </tr>
            <tr>
                <td colspan="1"><b>2</b></td>
                <td colspan="5">{{$proyecto->present()->proyectoSegundoObjetivo()}}</td>
            </tr>
            <tr>
                <td colspan="1"><b>3</b></td>
                <td colspan="5">{{$proyecto->present()->proyectoTercerObjetivo()}}</td>
            </tr>
            <tr>
                <td colspan="1"><b>4</b></td>
                <td colspan="5">{{$proyecto->present()->proyectoCuartoObjetivo()}}</td>
            </tr>
            <tr>
                <td colspan="1"><b>ALCANCE DEL PROYECTO</b></td>
                <td colspan="5">
                    {{$proyecto->present()->proyectoAlcance()}}
                </td>
            </tr>
            <tr class="tr-striped">
                <td colspan="6" ><b>DATOS DE LA PROPIEDAD INTELECTUAL<b></td>
            </tr>
            <tr>
                <td  colspan="6"><b>PERSONAS (TALENTOS)</b></td>
            </tr>
            @if ($proyecto->users_propietarios->count() > 0)
                <tr>
                    <td colspan="1"><b>Documento</b></td>
                    <td colspan="5"><b>PERSONA</b></td>
                </tr>
                @foreach ($proyecto->users_propietarios as $key => $value)
                    <tr>
                        <td colspan="1" >{{$value->documento}}</td>
                        <td colspan="5" >{{$value->nombres}} {{$value->apellidos}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" >No se encontraron personas dueñas de la propiedad intelectual.</td>
                </tr>
            @endif
            <tr>
                <td  colspan="6"><b>EMPRESAS</b></td>
            </tr>
            @if ($proyecto->sedes->count() > 0)
                <tr>
                    <td colspan="1"><b>Nit</b></td>
                    <td colspan="5"><b>Nombre de empresa</b></td>
                </tr>
                @foreach ($proyecto->sedes as $key => $value)
                    <tr>
                        <td colspan="1" >{{$value->empresa->nit}}</td>
                        <td colspan="5" >{{ $value->empresa->nombre }} ({{ $value->nombre_sede }})</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" >No se encontraron personas dueñas de la propiedad intelectual.</td>
                </tr>
            @endif
            <tr>
                <td  colspan="6"><b>GRUPOS DE INVESTIGACIÓN</b></td>
            </tr>
            @if ($proyecto->gruposinvestigacion->count() > 0)
                <tr>
                    <td colspan="1"><b>Código grupo</b></td>
                    <td colspan="5"><b>Grupo de investigación</b></td>
                </tr>
                @foreach ($proyecto->gruposinvestigacion as $key => $value)
                    <tr>
                        <td colspan="1" >{{$value->codigo_grupo}}</td>
                        <td colspan="5" >{{ $value->entidad->nombre }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" >No se encontraron personas dueñas de la propiedad intelectual.</td>
                </tr>
            @endif
            <tr class="tr-striped">
                <td colspan="6" ><b>ASISTENTES<b></td>
            </tr>
            <tr>
                <td colspan="6" class="left">{{$proyecto->present()->proyectoUserAsesor()}} - Experto</td>
            </tr>
            <tr>
                <td colspan="6" class="left">{{$proyecto->present()->talentoInterlocutor()}} - Talento Interlocutor</td>
            </tr>
        </table>
    </div>
</body>
</html>
