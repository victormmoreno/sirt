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
            word-wrap: break-word;
        }

        table {
            width: 100%;
            display: table;
            font-size: 13px;
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
    @media only screen and (max-width: 992px) {
        table.responsive-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            display: block;
            position: relative;
            /* sort out borders */
        }
        table.responsive-table td:empty:before {
            content: '\00a0';
        }
        table.responsive-table th,
        table.responsive-table td {

            vertical-align: top;
        }
        table.responsive-table th {
            text-align: left;
        }
        table.responsive-table thead {
            display: block;
            float: left;
        }
        table.responsive-table thead tr {
            display: block;
            padding: 0 0 0 0;
        }
        table.responsive-table thead tr th::before {
            content: "\00a0";
        }
        table.responsive-table tbody {
            display: block;
            width: auto;
            position: relative;
            overflow-x: auto;
            white-space: nowrap;
        }
        table.responsive-table tbody tr {
            display: inline-block;
            vertical-align: top;
        }
        table.responsive-table th {
            display: block;
            text-align: right;
        }
        table.responsive-table td {
            display: block;
            min-height: 1.25em;
            text-align: left;
        }
        table.responsive-table tr {
            padding: 0 0px;
        }
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Acta de Cierre</title>
</head>
<body>
    <footer>
        GD-F-007 V01
    </footer>
    <div class="card-content">
        <table class="bordered">
            <tr>
                <td colspan="1" rowspan="2"><img class="center-image" src="{{asset('img/web.png')}}"></td>
                <td colspan="5" class="centered"><b>Acta de Cierre<b></td>
            </tr>
            <tr>
                <td colspan="5" class="centered"><b>ACTA No. {{ $proyecto->id . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}<b></td>
            </tr>
        </table>
        <br>
        <table class="bordered">
            <tr>
                <td class="centrar" scope="row" colspan="6"><b>TÍTULO DE PROYECTO: {{$proyecto->present()->proyectoName()}}</b></td>
            </tr>
            <tr>
                <td colspan="1" scope="row">Nodo: <b>{{$proyecto->present()->proyectoNode()}}</b></td>
                <td colspan="2">Fecha: <b>{{Carbon\Carbon::now()->isoFormat('YYYY-MM-DD')}}</b></td>
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
                    @if ($proyecto->areaconocimiento->nombre == 'Otro')
                    <br>
                    {{$proyecto->present()->proyectoOtroAreaConocimiento()}}
                    @endif
                </td>
                <td colspan="3">Sublínea: <b>{{$proyecto->present()->proyectoSublinea() }}</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    @if ($proyecto->trl_obtenido == 0)
                    <p>TRL obtenido: <b>TRL 6</b></p>
                    @elseif($proyecto->trl_obtenido == 1)
                    <p>TRL obtenido: <b>TRL 7</b></p>
                    @else
                    <p>TRL obtenido: <b>TRL 8</span></p>
                    @endif
                </td>
                <td colspan="2">
                    ¿Dirigido al área de emprendimiento SENA?: <b>{{$proyecto->diri_ar_emp == 0 ? 'NO' : 'SI'}}</b>
                </td>
                <td colspan="2">
                    Costo aproximado del proyecto: <b>$ {{$costo->getData()->costosTotales}}</b></span>
                </td>
            </tr>
            <tr class="tr-striped">
                <td colspan="6" ><b>TALENTOS QUE PARTICIPAN EN EL PROYECTO<b></td>
            </tr>
            <tr>
                <td colspan="1"><b> Interlocutor</b></td>
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
                <td colspan="6" ><b>OBJETIVOS CUMPLIDOS DEL PROYECTO Y CONCLUSIONES<b></td>
            </tr>
            <tr>
                <td colspan="6"><b>OBJETIVOS ESPECÍFICOS CUMPLIDOS</b></td>
            </tr>
            <tr>
                <td colspan="1"><b>Item</b></td>
                <td colspan="4"><b>Objetivo</b></td>
                <td colspan="1"><b>¿Se cumplió?</b></td>
            </tr>
            <tr>
                <td colspan="1"><b>1</b></td>
                <td colspan="4"> {{ $proyecto->present()->proyectoPrimerObjetivo() }}</td>
                <td colspan="1">{{ $proyecto->present()->isProyectoCumplioPrimerObjetivo() }}</td>
            </tr>
            <tr>
                <td colspan="1"><b>2</b></td>
                <td colspan="4"> {{ $proyecto->present()->proyectoSegundoObjetivo() }}</td>
                <td colspan="1">{{ $proyecto->present()->isProyectoCumplioSegundoObjetivo()}}</td>
            </tr>
            <tr>
                <td colspan="1"><b>3</b></td>
                <td colspan="4"> {{ $proyecto->present()->proyectoTercerObjetivo() }}</td>
                <td colspan="1">{{ $proyecto->present()->isProyectoCumplioTercerObjetivo() }}</td>
            </tr>
            <tr>
                <td colspan="1"><b>4</b></td>
                <td colspan="4"> {{ $proyecto->present()->proyectoCuartoObjetivo() }}</td>
                <td colspan="1">{{ $proyecto->present()->isProyectoCumplioCuartoObjetivo() }}</td>
            </tr>
            <tr class="tr-striped">
                <td colspan="6" ><b>CONCLUSIONES Y SIGUIENTE PASO DEL PROYECTO<b></td>
            </tr>
            <tr>
                <td colspan="6">
                    {{$proyecto->conclusiones}}
                </td>
            </tr>
            <tr class="tr-striped">
                <td colspan="6" ><b>EVIDENCIAS TRL<b></td>
            </tr>
            <tr>
                <td colspan="1"><b>EVIDENCIAS DE PROTOTIPO DEL PRODUCTO</b></td>
                <td colspan="5">{{$proyecto->present()->proyectoTrlPrototipo()}}</td>
            </tr>
            <tr>
                <td colspan="1"><b>EVIDENCIAS DE PRUEBAS DOCUMENTADAS</b></td>
                <td colspan="5">{{$proyecto->present()->proyectoEvidenciasPruebasDocumentadas()}}</td>
            </tr>
            <tr>
                <td colspan="1"><b>EVIDENCIAS DE MODELO DE NEGOCIO</b></td>
                <td colspan="5">{{$proyecto->present()->proyectoEvidenciasModeloNegocio()}}</td>
            </tr>
            <tr>
                <td colspan="1"><b>EVIDENCIAS DE NORMATIVIDAD</b></td>
                <td colspan="5">{{$proyecto->present()->proyectoEvidenciasNormatividad()}}</td>
            </tr>
            <tr class="tr-striped">
                <td colspan="6" ><b>ASISTENTES<b></td>
            </tr>
            <tr>
                <td colspan="6" >{{$proyecto->present()->proyectoUserAsesor()}} - Experto</td>
            </tr>
            <tr>
                <td colspan="6" >{{$proyecto->present()->talentoInterlocutor()}} - Talento Interlocutor</td>
            </tr>
        </table>
    </div>
</body>
</html>
