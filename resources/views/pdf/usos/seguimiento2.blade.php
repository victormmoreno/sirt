<!doctype html>
<html lang="es">
    <head>
    <style>
        @page {
            margin: 10px 5px 10px 5px;
            border: solid;

        }


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
                height: 10px;
            }

            .tr-striped {
                background-color: #bdbdbd;
            }
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}
    <title>Seguimiento</title>
</head>
<body>
    <div class="card-content">
        <table class="bordered">
            <tr>
                {{-- <td colspan="1" rowspan="2"><img class="center-image" src="{{asset('img/web.png')}}"></td> --}}
                <td colspan="8" class="centered"><b>Seguimiento de Asesorias y Uso Infraestructura<b></td>
            </tr>
            <tr>
                <td colspan="8" class="centered">
                @if ($tipo_actividad == 'proyecto')
                    <b>ACTA No. {{ substr($data->present()->proyectoCode(), -4) . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}<b>
                @elseif($tipo_actividad == 'articulacion')
                    <b>ACTA No. {{ substr($data->present()->articulacionCode(), -4) . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}<b>
                @else
                <b><b>
                @endif
                </td>
            </tr>
            <tr class="tr-striped">
                <td colspan="8" ><b>Información general<b></td>
            </tr>
            <tr>
            @if ($tipo_actividad == 'proyecto')
                <td colspan="2">Código del proyecto</td>
                <td colspan="2">Nombre del proyecto</td>
                <td colspan="2">Asesor a cargo del proyecto</td>
                <td colspan="2">Sublínea tecnológica</td>
            @elseif($tipo_actividad == 'articulacion')
                <td colspan="2">Código de la articulación</td>
                <td colspan="3">Nombre de la articulación</td>
                <td colspan="3">Asesor a cargo de la articulación</td>
            @else
                <td colspan="8">No Registra</td>
            @endif
            </tr>
            <tr>
                @if ($tipo_actividad == 'proyecto')
                    <td colspan="2">{{$data->present()->proyectoCode() }}</td>
                    <td colspan="2">{{$data->present()->proyectoName()}}</td>
                    <td colspan="2">{{$data->present()->proyectoUserAsesor() }}</td>
                    <td colspan="2">{{$data->present()->proyectoAbreviaturaLinea() }} - {{$data->present()->proyectoSublinea() }}</td>
                @elseif($tipo_actividad == 'articulacion')
                    <td colspan="2">{{$data->present()->articulacionCode()}}</td>
                    <td colspan="3">{{$data->present()->articulacionName() }}</td>
                    <td colspan="3"></td>
                @else
                    <td colspan="8">No Registra</td>
                @endif
            </tr>
            <tr class="tr-striped">
                <td colspan="8" >
                    <b>
                    @if ($tipo_actividad == 'proyecto')
                        Talentos del Proyecto
                    @elseif($tipo_actividad == 'articulacion')
                        Talentos de la Articulación
                    @else
                        Talentos
                    @endif
                    </b>
                </td>
            </tr>
            @if ($tipo_actividad == 'proyecto')
                <tr>
                    <td colspan="2">Número de documento</td>
                    <td colspan="2">Nombres y apellidos</td>
                    <td colspan="2">Correo electrónico</td>
                    <td colspan="2">Número de contacto</td>
                </tr>
                @forelse ($data->articulacion_proyecto->talentos as $value)
                    <tr>
                        <td colspan="2">{{ $value->user->present()->userDocumento() }}</td>
                        <td colspan="2">{{ $value->user->present()->userFullName()}}</td>
                        <td colspan="2">{{ $value->user->present()->userEmail() }}</td>
                        <td colspan="2">{{ $value->user->present()->userCelular() }} - {{ $value->user->present()->userTelefono() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                    </tr>
                @endforelse

            @elseif($tipo_actividad == 'articulacion')
                <tr>
                    <td colspan="2">Número de documento</td>
                    <td colspan="2">Nombres y apellidos</td>
                    <td colspan="2">Correo electrónico</td>
                    <td colspan="2">Número de contacto</td>
                </tr>
                @forelse ($data->talentos as $value)
                    <tr>
                        <td colspan="2">{{ $value->user->present()->userDocumento() }}</td>
                        <td colspan="2">{{ $value->user->present()->userFullName()}}</td>
                        <td colspan="2">{{ $value->user->present()->userEmail() }}</td>
                        <td colspan="2">{{ $value->user->present()->userCelular() }} - {{ $value->user->present()->userTelefono() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                    </tr>
                @endforelse
            @else
                <tr>
                    <td colspan="8">No Registra</td>
                </tr>
            @endif
            <tr class="tr-striped">
                <td colspan="8" >
                    <b>Asesorías y usos</b>
                </td>
            </tr>
            <tr>
                <td colspan="1" rowspan="2">Fecha de la Asesoría y uso</td>
                <td colspan="1" rowspan="2">Horas de Asesoria Directa</td>
                <td colspan="1" rowspan="2">Horas de Asesoria Indirecta</td>
                <td colspan="1" rowspan="2">Equipos</td>
                <td colspan="1" rowspan="2">Materiales de Formación</td>
                <td colspan="2" rowspan="2">Descripción</td>
                <td colspan="1" rowspan="2">Funcionario / Talento</td>
            </tr>
            <tr>
            </tr>

                @forelse ($data->asesorias->sortBy('fecha')->values()->all() as $value)
                <tr>
                    <td>{{ $value->fecha->isoFormat('YYYY-MM-DD') }}</td>
                    <td>{{ $value->usogestores->sum('pivot.asesoria_directa') }}</td>
                    <td>{{ $value->usogestores->sum('pivot.asesoria_indirecta') }}</td>
                    <td>{{ $value->usoequipos->map(function ($item, $key) {
                                if(isset($item)){
                                    return $item->referencia . ' - ' . $item->present()->equipoNombre() . ' - Horas Uso: ' . $item->pivot->tiempo;
                                }
                                return "No registra";
                            })->implode(', ')}}
                    </td>
                    <td>
                        {{ $value->usomateriales->map(function ($item, $key) {
                            if(isset($item)){
                                return $item->codigo_material . ' - ' . $item->nombre. ' - Cantidad Uso: ' . $item->pivot->unidad;
                            }
                            return "No registra";
                        })->implode(', ')}}
                    </td>
                    <td colspan="2" >{{$value->descripcion}}</td>
                    <td colspan="1" >{{$value->present()->asesor()}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">No Registra</td>
                </tr>
                @endforelse
            @if ($tipo_actividad == 'proyecto')
                <tr class="tr-striped">
                    <td colspan="8" ><b>Certificación<b></td>
                </tr>

                <tr>
                    <td colspan="4" >{{$data->present()->proyectoUserAsesor()}} - Experto</td>
                    <td colspan="4" ></td>
                </tr>

                <tr>
                    <td colspan="4" >{{$data->present()->talentoInterlocutor()}} - Talento Interlocutor</td>
                    <td colspan="4" ></td>
                </tr>
            @elseif($tipo_actividad == 'articulacion')
                <tr class="tr-striped">
                    <td colspan="8" ><b>Certificación<b></td>
                </tr>
                <tr>
                    <td colspan="4" > - Articulador</td>
                    <td colspan="4" ></td>
                </tr>
                <tr>
                    <td colspan="4" >{{$data->present()->fullNameTalentInterlocutor()}} - Talento Interlocutor</td>
                    <td colspan="4" ></td>
                </tr>
            @else
            <tr>
                <td colspan="8">No Registra</td>
            </tr>
            @endif
        </table>
    </div>
</body>
</html>
