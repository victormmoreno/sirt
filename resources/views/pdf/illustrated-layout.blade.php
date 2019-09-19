<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
        <title>
            {{config('app.name')}} | @yield('title', config('app.name'))
        </title>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
        <link href="{{ asset('img/web.png') }}" rel="shortcut icon" type="image/x-icon"/>
    

        <style type="text/css">
        body,
        body *:not(html):not(style):not(br):not(tr):not(code) {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
                'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
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
            color: #00838f;
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


        /* Typography */

        h1 {
            color: #3d4852;
            font-size: 19px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        h2 {
            color: #3d4852;
            font-size: 16px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        h3 {
            color: #3d4852;
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

        img .certificated {

        }


        /* Layout */

        .wrapper {
            background-color: #008981;
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
            color: #008981;
            font-size: 19px;
            font-weight: bold;
            text-decoration: none;
            text-shadow: 0 1px 0 white;
        }

        /* Body */


        .body {
            background-color: #e0f2f1;
            border-bottom: 1px solid #edeff2;
            border-top: 1px solid #edeff2;
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
            border: 4px solid #009688;
            margin: 0 auto;
            padding: 0;
            width: 570px;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 570px;
        }

        /* Subcopy */

        .subcopy {
            border-top: 1px solid #008981;
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
            width: 250;
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
            color: #008981;

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
         /*  writing-mode: vertical-lr;*/
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
            color:#008981;
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
            @yield('image-header')
                    @yield('message')
                    @yield('image-footer')
        </div>
    </body>
</html>
