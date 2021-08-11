<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
        <title>
            Certificado | {{$user->present()->userFullName()}}
        </title>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
        <link href="{{ asset('img/web.png') }}" rel="shortcut icon" type="image/x-icon"/>

        <style type="text/css">
        body,
        body *:not(html):not(style):not(br):not(tr):not(code) {
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: #f8fafc;
            color: #74787e;
            height: 100%;
            hyphens: auto;
            line-height: 1.4;
            margin: 0;
            -moz-hyphens: auto;
            -ms-word-break: break-all;
            width: 100% !important;
            -webkit-hyphens: auto;
            -webkit-text-size-adjust: none;
            word-break: break-all;
            word-break: break-word;
            border: PowderBlue 5px double;
            border-top-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }


        p,
        ul,
        ol,
        blockquote {
            line-height: 1.4;
            text-align: left;
        }

        a {
            color: #ff9800 !important;
            text-decoration:none;
            font-weight: 600;
        }

        a img {
            border: none;
        }

        img {
            border-style: none;
        }


        .card-image {
            height: 89px;
            width: 342px;
        }

        .certificad{
            margin: 0px 35px;
        }

        .center,
        .center-align {
            text-align: center;
            align-content: center;

        }
        .page:after { content: counter(page, upper-roman); }


        h1 {
            color: #ff9800 !important;
            font-size: 19px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        h2 {
            color: #ff9800 !important;
            font-size: 16px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        h3 {
            color: #ff9800 !important;
            font-size: 14px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        p {
            color: #000000;
            font-size: 16px;
            line-height: 1.5em;
            margin-top: 0;
            text-align: left;
        }

        p.sub {
            font-size: 12px;
        }

        img {
            max-width: 100%;
        }


        /* Layout */

        .wrapper {
            background-color: #ff9800 !important;
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .content {
            margin: 20px 30px;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }


        /* Header */

        .header {
            padding: 25px 0;
            text-align: center;
        }

        .header a {
            color: #ff9800 !important;
            font-size: 19px;
            font-weight: bold;
            text-decoration: none;
            text-shadow: 0 1px 0 white;
        }

        /* Body */


        .body {
            background-color: #e0f2f1;
            border-bottom: 1px solid #ff9800 !important;
            border-top: 1px solid #ff9800 !important;
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;

        }

        .inner-body {
            background-color: rgba(178, 223, 219, 0.2);
            /*opacity:0.6;*/
            border: 4px solid #ff9800 !important;
            margin: 0 auto;
            padding: 0;
            width: 570px;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 570px;
        }

        /* Subcopy */

        .subcopy {
            border-top: 1px solid #ff9800 !important;
            margin-top: 25px;
            padding-top: 25px;
        }

        .subcopy p {
            font-size: 12px;
        }

        /* Footer */

        .footer {
            margin: 0 auto;
            padding: 0;
            text-align: center;
            position: fixed;
            bottom: 50px;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 570px;


        }

        .image-footer-left {
            height: 60px;
            width: 250px;
            bottom: 40px;
            margin: 30px;
            padding: 0;
            text-align: center;
            position: fixed;

        }

        .image-footer-right{
            height: 60px;
            width: 250;
            bottom: 40px;
            margin: 30px;
            padding-left: 500px;
            text-align: center;
            position: fixed;
        }

        .footer p{
            color: black;
            font-size: 12px;
            text-align: center;
        }



        /* Tables */

        .table table {
            margin: 30px auto;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .table th {
            border-bottom: 1px solid #00796b;
            padding-bottom: 8px;
            margin: 0;
        }

        .table td {
            color: #000000;
            font-size: 18px;
            line-height: 18px;
            padding: 10px 0;
            margin: 0;
            border: 4px;
        }

        .content-cell {
            padding: 35px;
            text-align: center;

        }



        .panel {
            margin: 0 0 21px;
        }

        .panel-content {
            background-color: #f1f5f8;
            padding: 16px;
        }

        .panel-item {
            padding: 0;
        }

        .panel-item p:last-of-type {
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .tittle {
            text-align: center;
            color: #ff9800 !important;

        }


        /* Promotions */

        .promotion {
            background-color: #ffffff;
            border: 2px dashed #9ba2ab;
            margin: 0;
            margin-bottom: 25px;
            margin-top: 25px;
            padding: 24px;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .title-date{
            text-align: right;
            padding-top: -50px;
            font-size: 12px;
        }

        .title-date-rotate {
            text-align: left;
            font-size: 12px;
            transform: rotate(90deg);
        }

        .promotion h1 {
            text-align: center;
        }
        .promotion h2 {
            text-align: center;
        }

        .promotion p {
            font-size: 15px;
            text-align: justify;
        }
        p {
            text-align: justify;
        }

        .promotion table{
            padding: 3px;
            border-width: 1px;
            border-style: solid;
            border-color: #f79646 #ccc;
            width: 100%;
            border-collapse: collapse;

        }
        .subtittle{
            color:#ff9800 !important;
            text-align: center;
        }
        .subtittle-value{
            color:black;
            text-align: center;
        }
        </style>
</head>
    <body>
        <div class="content">
            <p class="title-date">
                http://sennova.senaedu.edu.co
            </p>
            <div class="header">
                <div class="center">
                    <p class="z-depth-3">
                        <center>
                            <img class="card-image" src="{{asset('img/logonacional_Negro.png')}}">
                            </img>
                        </center>
                    </p>
                </div>
            </div>
            <div class="certificad">
                <h1 class="tittle">
                    Certificado de Registro en el Sistema
                </h1>
                <p class="promotion">
                    La Red Tecnoparque Colombia
            brinda un servicio que apoya el desarrollo de proyectos innovadores de base tecnológica para generar productos y servicios  que contribuyan al crecimiento económico y la competitividad del país y las regiones, apalancados en los sectores de clase mundial.
                    <br/>
                    <br/>
                    Siendo un programa de innovación tecnológica del Servicio Nacional de Aprendizaje (SENA) dirigida a todos los Colombianos, que actúa como acelerador para el desarrollo de proyectos de I+D+i, La Red Tecnoparque Colombia,  hace constar que el señor(a)
                    <b>
                        {{$user->present()->userFullName()}}
                    </b>
                    identificado con
            {{$user->tipodocumento->nombre}} {{$user->documento}}, se inscribió en nuestro sistema el día
            {{optional($user->created_at)->isoFormat('LL')}}.
                    <br/>
                    <br/>
                    El presente certificado se genera el día {{Carbon\Carbon::now()->isoFormat('LL')}}, por solicitud del interesado.
                    <br/>
                    <br/>
                    Recuerde que todos nuestros servicios son públicos, gratuitos, indiscriminados y
            no requieren intermediarios.
                </p>
                <div class="footer">
                    <img class="image-footer-left" src="{{asset('img/logonacional_Negro.png')}}"/>
                    <img class="image-footer-right" src="{{asset('img/sennova.png')}}"/>
                    <p class="center">
                        {{config('app.url')}}
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>



