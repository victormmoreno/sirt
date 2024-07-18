<html>
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <title>
            @yield('title-file',config('app.name'))
        </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <meta content="@yield('meta-content', config('app.name'))" name="description"/>
        <link href="{{ asset('img/web.png') }}" rel="shortcut icon" type="image/x-icon"/>
        @yield('styles')
        <style>
            .counter:before {
                content: "Página " counter(page);
                font-size:8pt;
            }
            .counter {
                position: relative;
                color:#fff;
                text-align:end;
            }

            .center-image{
                vertical-align: middle;
                width: 45px;
                height: 45px;
                border-radius: 50%;
                margin-left: 10px;
            }
            .centered {
                text-align: center;
            }
            .left {
                text-align: left;
            }

            .font-bold {
                font-weight: bold;
            }

            footer.page-footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                color: white;
                margin-top: 0;
                padding-top: -20px;
                background-color: #39A900;
                font-size: 10px;
            }

            .h-70p {
                height: 70px;
            }

            .-mt-10p{
                margin-top: -10px;
            }

            .mt-3p{
                margin-top: 3px;
            }

            .text-center{
                text-align: center;
            }

            .-pt-20p{
                padding-top: -20px;
            }
            .p-30p-60p{
                padding: 30px 60px;
            }

            /*tables*/
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
                .primary-text{
                    color: #39A900;
                }
            }
        </style>
    </head>
    <body>
        <footer class="page-footer">
            <p class="text-center mt-3p" >
                <span class="font-bold p-30p-60p">Generado: {{Carbon\Carbon::now()->format('d-m-Y  h:i:s A')}}</span>
                | GD-F-007 V01 |
                <span class="counter"></span>
            </p>
            <p class="-pt-20p -mt-10p text-center font-bold">
                <span>{{config('app.url')}}</span>
            </p>
        </footer>
        @yield('content-pdf')
    </body>
</html>
