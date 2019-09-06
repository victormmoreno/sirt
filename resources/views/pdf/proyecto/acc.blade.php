<html xmlns="http://www.w3.org/1999/xhtml">
<style>
.page-break {
    page-break-after: always;
}
body {
    font-family: "calibri-regular";
}
@font-face {
  font-family: 'calibri-regular';
  src: url("{{ storage_path('fonts\calibri-regular.ttf') }}") format("truetype");
  font-weight: 400;
  font-style: normal;
},
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<head>
  <title>Acuerdo de Confidencialidad y Compromiso</title>
</head>
<body>
  <table class="centered">
    <thead>
      <tr>
        <th width="30%">
          <img src="{{ asset('img/compromISO.png') }}" class="img-responsive" width="265" height="106">
        </th>
        <th width="70%">
          FORMATO DE CONFIDENCIALIDAD Y COMPROMISOS
          <br>
          <br>
          RED  TECNOPARQUE
        </th>
      </tr>
    </thead>
  </table>
  {{-- <center>
    <p class="z-depth-3">
      <img src="http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C" class="img-responsive" width="342" height="89">
    </p>
  </center> --}}
  <p style="text-align: justify">
    En la ciudad de <u><b>{{ $proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre }}</b></u> a los <u><b>{{ $proyecto->articulacion_proyecto->actividad->fecha_inicio->isoFormat('DD') }}</b></u> días del mes de
    <u><b>{{ $proyecto->articulacion_proyecto->actividad->fecha_inicio->monthName }}</b></u> de <u><b>{{ $proyecto->articulacion_proyecto->actividad->fecha_inicio->year }}</b></u>, se celebra la
    presente Acta de Confidencialidad y Compromisos entre la Red TecnoParque SENA Nodo
    <u><b>{{ $proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre }}</b></u> representado por los firmantes abajo en este documento, y por otra parte el Talento
    <u><b>{{ $talento_lider->nombre_talento }}</b></u>, identificado con <u><b>{{ $talento_lider->nombre_documento }}</b></u> N° <u><b>{{ $talento_lider->documento }}</b></u>
    de <u><b>lugar de expedición del documento</b></u>, quien en adelante se denominará El Talento Interlocutor del proyecto:
    <br>
    <br>
    <u><b>“{{ $proyecto->articulacion_proyecto->actividad->nombre }}”</b></u>
    <br>
    <br>
    Registrado con Número: <u><b>{{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}</b></u>, previas las siguientes consideraciones:
  </p>
  <p style="text-align: center">
    <br>
    <b>CONSIDERACIONES</b>
  </p>
  <p style="text-align: justify">
    <br>
    Debido a la naturaleza del trabajo de I+D+i, se puede hacer necesario que las partes manejen información confidencial y/o sujeta a derechos de propiedad intelectual, durante la etapa de la implementación del proyecto,
    a su vez se establecen un conjunto de compromisos entre la Red Tecnoparque SENA y los nuevos Talentos articulados.
    <br>
    <br>
    En mérito a lo expuesto se
    <br>
  </p>
  <p style="text-align: center">
    <br>
    <b>ACUERDA:</b>
    <br>
  </p>
  <p style="text-align: center">
    <br>
    <b>CAPITULO I</b>
    <br>
  </p>
  <p style="text-align: center">
    <br>
    <b>DE LA CONFIDENCIALIDAD</b>
    <br>
  </p>
  <p style="text-align: justify">
    <b>PRIMERO. OBJETO.</b> El objeto del presente acuerdo es fijar los términos y condiciones bajo los cuales las partes mantendrán la confidencialidad de los datos e información intercambiados entre ellas,
    incluyendo derechos de autor, patentes, técnicas, modelos, invenciones, know-how, procesos, algoritmos, programas, ejecutables, investigaciones, detalles de diseño, información financiera, lista de clientes,
    bases de datos, inversionistas, empleados, relaciones de negocios y contractuales, pronósticos de negocios, planes de mercadeo o cualquier información revelada, sobre terceras personas y que no sea de
    dominio público u obvio, antes de la firma de la presente acta.
  </p>
  <br>
  <br>
  <br>
  <br>
  <h6 style="position: bottom" class="right-align grey-text">GIC-F-041</h6>
  {{-- <center>
    <a><img src="https://i.ibb.co/M7vksPf/sennova.png" border="0" style="position: absolute; bottom: 0"  width="200" height="60"></a>
  </center> --}}
  <div class="page-break"></div>
  <h1>Page 2</h1>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
{{-- {{$nombre_proyecto}}
{{$correo_contacto }} --}}
