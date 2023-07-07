<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CERTIFICACIÓN EMPRESARIOS CONSULTORÍA RED TP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'Josefin Sans Bold';
            src: url({{ storage_path('fonts/josefin-sans-bold.ttf') }}) format("truetype");
        }
        @font-face {
            font-family: 'Josefin Sans';
            src: url({{ storage_path('fonts/josefin-sans.ttf') }}) format("truetype");
        }

        * {
            padding: 0;
            margin: 0 auto;
            list-style: none;
            text-decoration: none;
            box-sizing: border-box;
            font-family: 'Josefin Sans', arial;
        }

        #pdf {
            width: 800px;
            height: 800px;
            margin-top: 10px;
            padding-top: 30px;
        }

        #contenedor {
            width: 700px;
            height: 700px;
            position: relative;
        }

        #contenedor h4 {
            text-align: center;
            font-family: 'Josefin Sans Bold', arial;
        }


        .titulo-principal {
            margin-bottom: 50px;
        }

        .font-jose-bold {
            font-family: 'Josefin Sans Bold', arial;
            width: 20%;
            height: 60px;
            padding: 5px;
            text-align: left;
        }

        .subtitulos1{
            position: absolute;
            text-align: center;
            top: 60px;
            left: 285px;
        }

        .subtitulos2{
            position: absolute;
            text-align: center;
            top: 70px;
            left: 170px;
        }
        .subtitulos3{
            position: absolute;
            text-align: center;
            top: 90px;
            left: 175px;
        }
        .subtitulos4{
            position: absolute;
            text-align: center;
            top: 110px;
            left: 290px;
        }

        .parrafo {
            position: absolute;
            top: 130px;
        }


        #contenedor p {
            font-size: 1em ;
            margin-top: 10px;
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .jb-parr {
            font-family: 'Josefin Sans Bold', arial;
            text-align: center;
        }

        table,
        td,
        th {
            border: 1px solid black;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            position: absolute;
            top: 250px;
        }

        th {
            width: 20%;
            height: 60px;
            padding: 5px;
            text-align: left;
        }

        td {
            padding: 5px;
        }

        .parra{
            position: absolute;
            top: 750px;
        }

        .p-1{
            position: absolute;
            top: 830px;
            right: 0px;
        }

        .p-2{
            position: absolute;
            top: 850px;
            right: 0px;
        }

        .p-3{
            position: absolute;
            top: 870px;
            right: 0px;
        }

        .p-4{
            position: absolute;
            top: 890px;
            right: 0px;
        }
        .linea {
            width: 400px;
            height: 1px;
            background-color: black;
            position: absolute;
            top: 820px;
            right: 0px;
        }
    </style>
</head>
<body>
    <div id="pdf">
        <div id="contenedor">
            <p class="titulo-principal jb-parr">CARTA DE CERTIFICACIÓN / PARTICIPACIÓN EN CONSULTORÍA CIENTÍFICO TÉCNICA</p>
            <p class="subtitulos1 jb-parr">EL SUSCRITO</p>
            <p class="subtitulos2 jb-parr">{{$request->txtnombre_rep}} C.C. No. {{$request->txtdocumento_rep}}</p>
            <p class="subtitulos3 jb-parr">EN CALIDAD DE REPRESENTANTE</p>
            <p class="subtitulos4 jb-parr">CERTIFICA:</p>
            <p class="parrafo">Que {{$proyecto->present()->proyectoUserAsesor()}} ,
                integrante del equipo de profesionales de Tecnoparque {{$proyecto->present()->proyectoNode()}} del {{$proyecto->present()->proyectoNodoCentro()}}, avalado institucionalmente por el Servicio Nacional de Aprendizaje (SENA), ha participado en la siguiente consultoría científico-técnica
                utilizada para toma de decisión para la creación y/o mejoramiento de nuevos productos y servicios:</p>
            <table>
                <tr>
                    <td class="font-jose-bold">TÍTULO DE LA CONSULTORÍA</td>
                    <td>{{$proyecto->present()->proyectoName()}}</td>
                </tr>

                <tr>
                    <td class="font-jose-bold">FECHA DE INICIO DE LA CONSULTORÍA</td>
                    <td>{{$proyecto->fecha_inicio->format('Y-m-d')}}</td>
                </tr>

                <tr>
                    <td class="font-jose-bold">OBJETO DE LA CONSULTORÍA</td>
                    <td>{{$proyecto->present()->proyectoObjetivoGeneral()}}</td>
                </tr>

                <tr>
                    <td class="font-jose-bold">FECHA DE FINAL DE LA CONSULTORÍA</td>
                    <td>{{$proyecto->fecha_cierre->format('Y-m-d')}}</td>
                </tr>
                <tr>
                    <td class="font-jose-bold">TRL OBTENIDO DEL PROTOTIPO O PRODUCTO / SERVICIO</td>
                    @if ($proyecto->trl_obtenido == App\Models\Proyecto::IsTrl6Obtenido())
                    <td>TRL 6</td>
                    @endif
                    @if ($proyecto->trl_obtenido == App\Models\Proyecto::IsTrl7Obtenido())
                    <td>TRL 7</td>
                    @endif
                    @if ($proyecto->trl_obtenido == App\Models\Proyecto::IsTrl8Obtenido())
                    <td>TRL 8</td>
                    @endif
                </tr>

                <tr>
                    <td class="font-jose-bold">CALIFICACIÓN DE LA CALIDAD DE LA CONSULTORÍA</td>
                    <td>{{$request->txtdesempenho}} </td>
                </tr>

            </table>
            <p class="parra">La presente certificación se expide a los {{Carbon\Carbon::now()->isoFormat('DD')}} días del mes de {{Carbon\Carbon::now()->isoFormat('MMMM')}} del año {{Carbon\Carbon::now()->isoFormat('YYYY')}}</p>
            <div class="linea"></div>
            <p class="p-derecha p-1">{{$request->txtnombre_rep}}</p>
            <p class="p-derecha p-2">C.C {{$request->txtdocumento_rep}} </p>
            <p class="p-derecha p-3">{{$entidad['nombre']}} </p>
            @if ($entidad['tipo'] == 'Empresa')
            <p class="p-derecha p-4">NIT {{$entidad['codigo']}}</p>
            @else
            <p class="p-derecha p-4">Código {{$entidad['codigo']}}</p>
            @endif
        </div>
    </div>
</body>
</html>
