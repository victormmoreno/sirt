<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<head>
  <title>Carta de Recomendaciones</title>
</head>
<body>
  <center>
    <p class="z-depth-3">
      <img src="http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C" class="img-responsive" width="342" height="89">
    </p>
  </center>
  <p>
    Señor(a) <br>
    <b>{{ $idea->user->nombres }} {{ $idea->user->apellidos }}</b><br>
    Cordial Saludo
  </p>
  <p style="text-align: justify">
    Luego de analizar la información presentada en el Comité de Selección de Ideas de Base Tecnológica realizado en el 
    mes de {{ $comite->fechacomite->isoFormat('MMMM [de] YYYY') }}, el comité evaluador considera la No aceptación del proyecto <b>“{{ $idea->datos_idea->nombre_proyecto->answer }}”</b>.
    Para esto le solicitamos seguir las siguientes recomendaciones.
    <br>
    <br>
    Lo invitamos seguir las siguientes recomendaciones y observaciones:
  </p>
  <p style="text-align: left">
    {{ $idea->comites()->wherePivot('comite_id', $comite->id)->first()->pivot->observaciones }}
  </p>
  <p style="text-align: justify">
    Luego de seguir las recomendaciones usted podrá solicitar una nueva citación al comité y este decidirá si se le asigna un experto de Tecnoparque,
    quien lo contactará para iniciar con la metodología en caso de que el proyecto se admitido.
    Cualquier información adicional la puede solicitar a los teléfonos {{ $idea->nodo->telefono }} <b>ext.</b> {{ $idea->nodo->extension }}.
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
