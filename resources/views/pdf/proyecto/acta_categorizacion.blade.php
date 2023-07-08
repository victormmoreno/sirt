<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
        <style>
            .centrar {
                text-align: center;
            }
            footer {
                position: fixed;
                left: 0px;
                bottom: -50px;
                right: 0px;
                height: 40px;
                border-bottom: 2px solid #ddd;
                text-align: right;
            }
            footer .page:after {
                content: counter(page);
            }
        </style>
        <title>Acta de Inicio de Categorización</title>
    </head>
    <body>
        <footer>
            GD-F-007 V01
        </footer>
        <table class="table-bordered table-sm">
        <thead>
            <tr>
            <th colspan="1">
                <br>
                <center>
                    <img height="100px" src="{{asset('img/web.png')}}">
                </center>
            </th>
            <th colspan="5" class="centrar">ACTA DE INICIO PARA CATEGORIZACIÓN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td class="centrar" scope="row" colspan="6"><b>TÍTULO DE CONSULTORÍA: {{$proyecto->present()->proyectoName()}}</b></td>
            </tr>
            <tr>
            <td colspan="1" scope="row">Nodo: <b>{{$proyecto->present()->proyectoNode()}}</b></td>
            <td colspan="2">Fecha de inicio: <b>{{$proyecto->present()->proyectoFechaInicio()}}</b></td>
            <td colspan="3">Código del consultoría: <b>{{$proyecto->present()->proyectoCode()}}</b></td>
            </tr>
            <tr>
            <th class="centrar" colspan="6">DATOS DEL PROYECTO</th>
            </tr>
            <tr>
            <td colspan="6">Experto responsable de la consultoría: <b>{{$proyecto->present()->proyectoUserAsesor()}}</b></td>
            </tr>
            <tr>
            <td colspan="3">TRL que se pretende realizar: <b>{{$proyecto->present()->proyectoTrlEsperado()}}</b></td>
            <td colspan="3">Nombre de la Idea de Proyecto: <b>{{$proyecto->idea->present()->ideaName()}}</b></td>
            </tr>
            <tr>
            <th class="centrar" colspan="6">OBJETIVOS DEL PROYECTO</th>
            </tr>
            <tr>
            <th class="centrar" colspan="6"><small><b>OBJETIVO GENERAL</b></small></th>
            </tr>
            <tr>
            <td colspan="6">
                {{$proyecto->present()->proyectoObjetivoGeneral()}}
            </td>
            </tr>
            <tr>
            <th class="centrar" colspan="6"><small><b>OBJETIVOS ESPECÍFICOS</b></small></th>
            </tr>
            <tr>
            <td colspan="6">
                <ol>
                <li>Desarrollar el prototipo funcional del producto/servicio.</li>
                <li>Realizar pruebas de validación en un ambiente pertinente del prototipo.</li>
                <li>Generar Informe de Identificación de modelo de negocio - monetización y asimilación del mercado.</li>
                <li>Generar informe de identificación de los conceptos de salud y seguridad, limitaciones ambientales, regulatorios y de disponibilidad de recursos.</li>
                </ol>
            </td>
            </tr>
            <tr>
            <th class="centrar" colspan="6">DATOS DE LA PROPIEDAD INTELECTUAL</th>
            </tr>
            <tr>
            <th class="centrar" colspan="6"><small><b>EMPRESAS</b></small></th>
            </tr>
            <tr>
            <td colspan="6">
                @if ($proyecto->sedes->count() > 0)
                <ul>
                    @foreach ($proyecto->sedes as $key => $value)
                    <li>
                        {{$value->empresa->nit}} - {{ $value->empresa->nombre }} ({{ $value->nombre_sede }})
                    </li>
                    @endforeach
                </ul>
                @else
                <p>No se encontraron empresas dueñas de la propiedad intelectual.</p>
                @endif
            </td>
            </tr>
            <tr>
            <th class="centrar" colspan="6"><small><b>GRUPOS DE INVESTIGACIÓN</b></small></th>
            </tr>
            <tr>
            <td colspan="6">
                @if ($proyecto->gruposinvestigacion->count() > 0)
                <ul>
                    @foreach ($proyecto->gruposinvestigacion as $key => $value)
                    <li>
                        {{$value->codigo_grupo}} - {{ $value->entidad->nombre }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p>
                No se encontraron grupos de investigación dueños de la propiedad intelectual.
                </p>
                @endif
            </td>
            </tr>
        </tbody>
        </table>
    </body>
</html>
