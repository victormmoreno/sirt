<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<head>
  <title>Carta de Recomendaciones</title>
</head>
<body>
  <h6 class="right-align grey-text">Generado: {{Carbon\Carbon::now()}}</h6>
  <center>
    <p class="z-depth-3">
      <img src="http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C" class="img-responsive" width="342" height="89">
    </p>
  </center>
  <p>
    Señor(a) <br>
    <b>{{ $nombres_contacto }} {{ $apellidos_contacto }}</b><br>
    Cordial Saludo
  </p>
  <p style="text-align: justify">
    Luego de analizar la información presentada en el Comité de Selección de Ideas de Base Tecnológica
    realizado en el mes de {{ $FechaComite->isoFormat('MMMM [de] YYYY') }},
    La Red Tecnoparque Colombia
    del SENA le da la Bienvenida a su nodo <b>{{$nodoNombre}}</b>. Desde ahora usted hace parte del
    grupo de emprendedores innovadores de nuestra Red y recibirán de parte nuestra la
    Asesoría Técnica especializada y los servicios tecnológicos para el desarrollo de su
    idea: <b>“{{ $nombre_proyecto }}”</b>
    En los próximos días, el gestor asignado de Tecnoparque se pondrá en contacto con usted para generar una agenda de trabajo inicial.

  </p>
  <p>
    Recuerde que además de la Asesoría Técnica para el Desarrollo de Proyectos de Base Tecnológica, la Red Tecnoparque Colombia pone a su disposición los siguientes servicios:
  </p>
  <ul>
    <li type="disc">Apropiación y generación social del conocimiento.</li>
    <li type="disc">Servicios tecnológicos</li>
    <li type="disc">Fortalecimiento para la actividad empresarial a través de la Unidad de emprendimiento.</li>
    <li type="disc">Adaptación y transferencia tecnológica.</li>
  </ul>
  <p>
    Gracias por su participación e interés.<br>
    <b>
      Red Tecnoparque SENA<br>
    </b>
    http://tecnoparque.sena.edu.co
  </p>
  <center>
    <a><img src="https://i.ibb.co/M7vksPf/sennova.png" border="0" style="position: absolute; bottom: 0"  width="200" height="60"></a>
  </center>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
{{-- {{$nombre_proyecto}}
{{$correo_contacto }} --}}
