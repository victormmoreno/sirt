@php
    $asesor = auth()->user();
@endphp
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
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
            <td><b>{{__('articulation-stage Type')}}</b></td>
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
            <td colspan="6" style="height: 70px"></td>
        </tr>
        <tr>
            <td colspan="6" >{{$articulationStage->documento}} - {{$articulationStage->nombres}} {{$articulationStage->apellidos}} - Talento Interlocutor</td>
        </tr>
        <tr>
            <td colspan="6" style="height: 70px"></td>
        </tr>
        <tr>
            <td colspan="6" >{{$asesor->documento}} -  {{$asesor->nombres}} {{$asesor->apellidos}} - Asesor</td>
        </tr>


    </table>
</div>
</body>
</html>
