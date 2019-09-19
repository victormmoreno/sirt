<html>
<style>
.page-break {
    page-break-after: always;
}
body {
    font-family: "calibri-regular";
}
ylee {
  font-family: "ylee";
  font-size: 15;
  font-weight: normal;
  font-style: normal;
  line-height: 15px;
}
calibriBold {
  font-family: "calibri-bold";
  font-size: 10;
  font-weight: normal;
  font-style: normal;
  line-height: 15px;
}
@font-face {
  font-family: 'calibri-regular';
  src: url("{{ storage_path('fonts\calibri-regular.ttf') }}") format("truetype");
  font-weight: normal;
  font-style: normal;
},
@font-face {
  font-family: 'ylee';
  src: url("{{ storage_path('fonts\ylee.ttf') }}") format("truetype");
  font-weight: normal;
  font-style: normal;
},
.headerImg{
  font-size: 20px;
  border-style: solid;
  border-width: 1px;
  border-color: black;
  width: 300px;
  text-align: left;
}
.col.title1 {
  width: 46%;
  /* margin-left: 10mm; */
  left: auto;
  right: auto;
  bottom: auto;
  background-color: #A6A6A6;
}
.col.firmaRep {
  width: 46%;
  /* margin-left: 10mm; */
  left: auto;
  right: auto;
  bottom: auto;
  height: 146px;
  /* background-color: #A6A6A6; */
}
.col.contenedorGrande {
  width: 95.7%;
  /* margin-left: 10mm; */
  left: auto;
  right: auto;
  bottom: auto;
  height: 146px;
  /* background-color: #A6A6A6; */
}
.col.contenedorGrande2 {
  width: 95.7%;
  /* margin-left: 10mm; */
  left: auto;
  right: auto;
  bottom: auto;
  height: 100px;
  /* background-color: #A6A6A6; */
}
.col.title2 {
  width: 46%;
  /* margin-right: 30mm; */
  left: auto;
  right: auto;
  bottom: auto;
  background-color: #A6A6A6;
}
.col.firmaTec {
  width: 46%;
  /* margin-right: 30mm; */
  left: auto;
  right: auto;
  bottom: auto;
  height: 146px;
  /* background-color: #A6A6A6; */
}
.headerText{
  font-size: 10px;
  border-style: solid;
  border-width: 1px;
  border-color: black;
  width: 385px;
  height: 100px;
  right: 250px;
  text-align: center;
}
.marginPdf{
  margin: 0mm 10mm;
  line-height: 15px;
}
</style>
<link rel="stylesheet" href="{{ asset('css/app.css')}}">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> --}}
<head>
  <title>Acuerdo de Confidencialidad y Compromiso</title>
</head>
<body>
  <div class="row">
    <div class="center">
      <img src="{{ asset('img/encabezadoAcc.png') }}" class="img-responsive">
    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    En la ciudad de <u><calibriBold>{{ $proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre }}</calibriBold></u> a los
    <u><calibriBold>{{ $proyecto->articulacion_proyecto->actividad->fecha_inicio->isoFormat('DD') }}</calibriBold></u> días del mes de
    <u><calibriBold>{{ $proyecto->articulacion_proyecto->actividad->fecha_inicio->monthName }}</calibriBold></u> de <u><calibriBold>{{ $proyecto->articulacion_proyecto->actividad->fecha_inicio->year }}</calibriBold></u>,
    se celebra la presente Acta de Confidencialidad y Compromisos entre la Red TecnoParque SENA Nodo
    <u><calibriBold>{{ $proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre }}</calibriBold></u> representado por los firmantes abajo en este documento, y por otra parte el Talento
    <u><calibriBold>{{ $talento_lider->nombre_talento }}</b></u>, identificado con <u><calibriBold>{{ $talento_lider->nombre_documento }}</b></u> N° <u><calibriBold>{{ $talento_lider->documento }}</calibriBold></u>
    de <u><calibriBold>{{ $talento_lider->ciudad_expedicion }}</calibriBold></u>, quien en adelante se denominará <calibriBold>El Talento Interlocutor</calibriBold> del proyecto:
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <u><calibriBold>“{{ $proyecto->articulacion_proyecto->actividad->nombre }}”</calibriBold></u>
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    Registrado con Número: <u><calibriBold>{{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}</calibriBold></u>, previas las siguientes consideraciones:
  </p>
  <p style="text-align: center">
    <br>
    <calibriBold>CONSIDERACIONES</calibriBold>
  </p>
  <p style="text-align: justify;" class="marginPdf">
    <br>
    Debido a la naturaleza del trabajo de I+D+i, se puede hacer necesario que las partes manejen información confidencial y/o sujeta a derechos de propiedad intelectual, durante la etapa de la implementación del proyecto,
    a su vez se establecen un conjunto de compromisos entre la Red Tecnoparque SENA y los nuevos Talentos articulados.
    <br>
    <br>
    En mérito a lo expuesto se
    <br>
  </p>
  <p style="text-align: center">
    <calibriBold>ACUERDA:</calibriBold>
  </p>
  <p style="text-align: center">
    <calibriBold>CAPITULO I</calibriBold>
  </p>
  <p style="text-align: center">
    <calibriBold>DE LA CONFIDENCIALIDAD</calibriBold>
  </p>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>PRIMERO. OBJETO.</calibriBold> El objeto del presente acuerdo es fijar los términos y condiciones bajo los cuales las partes
    mantendrán la confidencialidad de los datos e información intercambiados entre ellas, incluyendo derechos de autor,
    patentes, técnicas, modelos, invenciones, know-how, procesos, algoritmos, programas, ejecutables, investigaciones,
    detalles de diseño, información financiera, lista de clientes, bases de datos, inversionistas, empleados, relaciones de
    negocios y contractuales, pronósticos de negocios, planes de mercadeo o cualquier información revelada, sobre terceras
    personas y que no sea de dominio público u obvio, antes de la firma de la presente acta.
  </p>
  <br>
  <br>
  <br>
  <br>
  <div class="row">
    <span style="position: bottom" class="right grey-text">GIC-F-041</span>
  </div>
  {{---------------------------------------------------------------------------- INICIO DE LA SEGUNDA PÁGINA DEL ACUERDO DE CONFIDENCILIDAD Y COMPROMISO ----------------------------------------------------------------------------}}
  <div class="page-break"></div>
  <div class="row">
    <div class="center">
      <img src="{{ asset('img/encabezadoAcc.png') }}" class="img-responsive">
    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  {{-- <br> --}}
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>SEGUNDO. DEFINICIÓN DE CONFIDENCIALIDAD.<sup>1</sup></calibriBold> Constituirá “Información Confidencial” las metodologías, tecnologías, planos, prototipos, programas de computador y propiedad intelectual e ideas del beneficio.
    Los resultados del proyecto pueden considerarse confidenciales, si el Talento así lo define. El SENA se reserva el uso de los resultados de los proyectos, cuando ello sea necesario o requerido por los procesos
    de formación profesional, respetando siempre la propiedad intelectual y comercial de los resultados, la reserva de la información clasificada como confidencial y que será expresamente determinada durante el proceso
    de aprobación y desarrollo del proyecto.
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>TERCERO. CONFIDENCIALIDAD.</calibriBold> Las partes acuerdan que cualquier información intercambiada, facilitada o creada entre ellas durante la implementación del proyecto,
    será mantenida en estricta confidencialidad. El Gestor o Gestores, Dinamizador, Infocenter y en general la Red Tecnoparque sólo podrá revelar información confidencial a quienes la necesiten y
    estén autorizados previamente por los Talentos/emprendedores integrantes que firman este documento. Se considera también información confidencial:
    a) La que no sea de fácil acceso,
    b) Aquella información que no esté sujeta a medidas de protección razonables, de acuerdo con las circunstancias del caso, a fin de mantener
    su carácter confidencial. El Talento o grupo de Talentos que se incorpora(n) a la Red Tecnoparque SENA, deberán mantener en total confidencialidad la información obtenida de otros Talentos, Gestores, etc.,
    la cual sea considerada como información confidencial.
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>CUARTO. EXCEPCIONES.</calibriBold> Teniendo en cuenta que las ideas no son protegidas por derechos de autor o patentes, no habrá deber alguno de confidencialidad en los siguientes casos:
    a) Cuando la parte receptora tenga evidencia de que conoce previamente la información recibida; b) Cuando la información recibida sea de dominio público; c) Cuando la información es revelada por
    el propietario y este acepta que puede ser utilizada como información de dominio público.
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>QUINTO. DURACIÓN.</calibriBold> Los <calibriBold>compromisos</calibriBold> que asume el Talento a través de este acuerdo regirán durante el tiempo que dure el desarrollo del proyecto y la presente vigencia,
    con respecto a la confidencialidad se regirá según el artículo tercero del presente acuerdo, siempre preservando la confidencialidad de la información durante y después de finalizado el proyecto (hasta 5 años)
    según los acuerdos que se establezcan entre el equipo de Talentos desarrollador del proyecto y el Nodo de la Red Tecnoparque.
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>SEXTO. DERECHOS DE PROPIEDAD.</calibriBold> De acuerdo con el Acuerdo No. 00009 de 2010, por el cual se establecen las políticas para el programa de Tecnoacademias y Tecnoparques,
    Capítulo II de los Tecnoparques, la propiedad intelectual del proyecto desarrollado en Tecnoparque será de sus autores, de conformidad con las normas vigentes que regulan la materia, respetando
    siempre dentro de los derechos morales la Imagen de la Red Tecnoparque/SENA como principal promotor y gestor del proyecto. En el caso de que Tecnoparque SENA requiera usar información catalogada como
    confidencial para el desarrollo de otros proyectos, deberá ser autorizado por escrito por el Talento propietario de esta información. Es responsabilidad del Talento iniciar los procesos de protección
    industrial de su proyecto, si considera que este es susceptible de algún mecanismo de protección Nacional o Internacional”. En el caso de los proyectos desarrollados en articulación con grupos de investigación,
    debido a la participación activa de los profesionales que trabajan en
  </p>

  {{---------------------------------------------------------------------------- INICIO DE LA TERCERA PÁGINA DEL ACUERDO DE CONFIDENCILIDAD Y COMPROMISO ----------------------------------------------------------------------------}}
  <div class="page-break"></div>
  <div class="row">
    <div class="center">
      <img src="{{ asset('img/encabezadoAcc.png') }}" class="img-responsive">
    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    Tecnoparque para la consolidación de la idea, los derechos morales y patrimoniales de propiedad intelectual son compartidos en igualdad de proporciones para las partes, a menos que se acuerden otras proporciones
    entre los representantes legales de las entidades.
  </p>
  <p style="text-align: center">
    <calibriBold>CAPITULO II</calibriBold>
  </p>
  <p style="text-align: center">
    <calibriBold>DE LOS COMPROMISOS Y EL DESARROLLO DE PROTOTIPOS Y PROYECTOS</calibriBold>
  </p>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>SÉPTIMO. OBJETO:</calibriBold> Fijar los términos y condiciones bajo los cuales las partes mantendrán un compromiso de horarios establecidos, reuniones de indispensable cumplimiento para el desarrollo del proyecto dentro de
    las instalaciones de la Red Tecnoparque, invitaciones y asistencia a diferentes eventos como ferias, conferencias, talleres, conversatorios, exposiciones, dentro y fuera de las instalaciones del Nodo.
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>OCTAVO. COMPROMISOS DE LA RED TECNOPARQUE SENA:</calibriBold> Es responsable de ofrecer sin ningún costo, asesoría técnica especializada y personalizada, herramientas e infraestructura necesaria
    para el desarrollo de iniciativas novedosas de productos y servicios de base tecnológica, susceptible de ser materializada en prototipos funcionales, ofreciendo adicionalmente:
  </p>
  <p>
    <ol type="1" style="text-align: justify; margin: 0mm 10mm 0mm 5mm; line-height: 15px;">
      <li>
        Orientación sobre entidades de fortalecimiento empresarial y financiación (La Red Tecnoparque SENA, NO financia ninguna clase de materiales, insumos, equipos, membresías, pagos, viajes, papelería,
        para el desarrollo, construcción o comercialización de prototipos).
      </li>
      <li>
        Acceso y uso de la infraestructura tecnológica en los horarios de servicio establecidos por cada Nodo.
      </li>
      <li>
        Oportunidades para participar en diferentes eventos como ferias, transferencia de tecnología, talleres y seminarios técnicos, encuentros tecnológicos, muestras empresariales, ruedas de negocios,
        entre otros, teniendo en cuenta los parámetros de selección que defina la Red Tecnoparque y el SENA.
      </li>
      <li>
        Cumplimiento del cronograma de trabajo definido entre los Talentos (Emprendedores) y los <calibriBold>Gestores de la Red</calibriBold> Tecnoparque, en donde los Gestores de la Red, cumplen con el servicio de
        asesoría técnica especializada y personalizada a los Talentos.
      </li>
      <li>
        Ofrecer el servicio de acceso a laboratorios en óptimas condiciones, garantizando el buen uso de la infraestructura.
      </li>
      <li>
        Contar con profesionales idóneos, para ofrecer un servicio de calidad en el acompañamiento y asesoría a las iniciativas innovadoras de base tecnológica que se desarrollan al interior de la Red Tecnoparque.
      </li>
    </ol>
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>NOVENO. COMPROMISOS DE LOS TALENTOS:</calibriBold> Por medio de la presente acta se compromete a:
  </p>
  <p>
    <ol type="1" style="text-align: justify; margin: 0mm 10mm 0mm 5mm; line-height: 15px;">
      <li>
        Elaborar los documentos de planeación avalados por la Red Tecnoparque SENA, los cuales deben ser entregados entre 3 a 10 días hábiles, luego de la firma de la presente Acta.
      </li>
      <li>
        Entregar a tiempo todos los documentos y las evidencias solicitadas por los gestores del Nodo, utilizando las herramientas de gestión dispuestas para tal fin.
      </li>
      <div class="page-break"></div>
      <div class="row">
        <div class="center">
          <img src="{{ asset('img/encabezadoAcc.png') }}" class="img-responsive">
        </div>
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <li>
        Cumplir con un horario de asistencia mínimo de horas semanales de trabajo Autónomo presenciales en el Nodo, el cual es establecido en común acuerdo con el gestor asignado, adicional deberá cumplir con
        dos (2) horas semanales de acompañamiento técnico por el Gestor para la Gestión del proyecto.
      </li>
      <li>
        Asistir al comité de seguimiento del proyecto y presentar al gestor asignado los avances en un informe, en donde se dará cumplimiento a los objetivos planteados al inicio del proceso y con las respectivas
        evidencias (fotos, videos, simulaciones, diseños, entre otras) que lo respalden, lo anterior como mecanismo de autoevaluación y seguimiento, por lo tanto es de carácter obligatorio.
      </li>
      <li>
        Asistir a las reuniones programadas por el Nodo.
      </li>
      <li>
        <calibriBold>Del comportamiento:</calibriBold> a) Mantener en todos los momentos (eventos, talleres, seminarios, trabajo en laboratorios, etc.) y espacios institucionales del SENA, un trato de respeto y buena convivencia.
        b) Utilizar la indumentaria y los elementos de protección personal dispuestos y/o solicitados por el Gestor a cargo del laboratorio. c) Conservar y mantener en buen estado, orden y aseo, las instalaciones físicas,
        equipos y herramientas de la entidad o que estén a cargo de ésta, respondiendo por los daños ocasionados a éstos intencionalmente o por descuido, debidamente comprobados.
      </li>
      <li>
        No realizar actividades diferentes a las requeridas por el proyecto dentro de instalaciones del Nodo o no avaladas por la Red, en caso de presentarse la necesidad deberá contar con la autorización del gestor
        asignado al proyecto.
      </li>
      <li>
        Una vez finalizado el proyecto, se firmara un Acta de Cierre del mismo, en donde el Talento entregará las evidencias de finalización como fotos, videos, simulaciones, diseños e informes correspondientes.
      </li>
      <li>
        El Talento en contraprestación a los servicios recibidos por la Red, deberá realizar promoción y difusión de la Imagen Red Tecnoparque SENA, esto durante el desarrollo del proyecto y una vez finalizado.
        Para ello utilizará el Logo SENA/Tecnoparque, el cual estará acompañado de la siguiente frase: <calibriBold>“Apoyado por la Red Tecnoparque”</calibriBold>, impreso y pegado sobre el prototipo del producto/servicio.
        Nunca en productos comerciales.
      </li>
      <li>
        Una vez finalizado el proyecto, asistir a la rueda de iniciativas empresariales, evento programado por el Nodo para la muestra, proyección y difusión de las iniciativas gestadas con el apoyo de la institución,
        para ello se deberán tener en cuenta las pautas para la selección de las iniciativas empresariales a presentar en el evento, estas pautas son diseñadas acorde a las particularidades de la región y el Nodo en el
        que se desarrollaron los proyectos.
      </li>
      <li>
        Conocer, aceptar y dar cumplimiento a los términos para uso de infraestructura adecuado de los diferentes laboratorios y equipos de la Red Tecnoparque SENA.
      </li>
    </ol>
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>DÉCIMO. TRANSFERENCIA DE CONOCIMIENTO:</calibriBold> En contrapartida por haber recibido el servicio de Asesoría técnica especializada y usos de infraestructura, en el desarrollo de proyectos de
    Base Tecnológica, el Talento cumplirá con alguna (s) de las siguientes actividades de Transferencia de Conocimiento. Éstas se ejecutan dentro del tiempo en el que el talento está recibiendo el servicio
    mencionado y se definen y cumplen de acuerdo con los cronogramas de trabajo que se construyen entre Gestores y Talentos en la etapa de planeación del proyecto:
  </p>
  <p>
    <ol type="1" style="text-align: justify; margin: 0mm 10mm 0mm 5mm; line-height: 15px;">
      <li>
        Desarrollar Charlas Informativas de casos de éxito para los nuevos Talentos articulados.
      </li>
      <li>
        Participar como ponente en un evento de divulgación tecnológica hacia empresa o academia.
      </li>
      <div class="page-break"></div>
      <div class="row">
        <div class="center">
          <img src="{{ asset('img/encabezadoAcc.png') }}" class="img-responsive">
        </div>
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>

      <li>
        Participar como expositor en actividades de transferencia de conocimiento entre talentos, diseñadas por la Red.
      </li>
      <li>
        Participar en eventos en representación del SENA.
      </li>
      <li>
        Apoyar procesos de actualización a Gestores Tecnoparque a través de transferencias de conocimiento.
      </li>
    </ol>
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    El Talento además debe diligenciar en su totalidad los documentos entregables y entregar uno de los productos, de acuerdo con la fase en la que se encuentre el proyecto y con los formatos establecidos por la Red,
    para ello deberá entregar una <calibriBold>cuenta de correo personal o empresarial</calibriBold> y compartir los documentos solicitados por el Gestor a cargo de las asesorías del proyecto. Los documentos en los
    que debe participar son:
  </p>
  <p>
    <ol type="a" style="font-family: 'calibri-bold'; text-align: justify; line-height: 15px; margin: 0mm 10mm 0mm 15mm;">
      <li>Acta de Inicio</li>
      <li>Ficha de caracterización del producto/servicio/prototipo</li>
      <li>Videotutorial</li>
      <li>Encuesta de satisfacción</li>
      <li>Acta de cierre</li>
    </ol>
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>SOBRE LA DIVULGACIÓN Y PUBLICACIÓN DE LOS VIDEOS TUTORIALES GENERADOS:</calibriBold>
    <br>
    De acuerdo con las actividades de generación y apropiación social del conocimiento que se desarrollan en la Red Tecnoparque SENA, los video-tutoriales serán publicados y divulgados en los canales públicos de YouTube y
    diferentes redes sociales, como una herramienta para la transferencia de conocimiento a la comunidad SENA y los usuarios de la Red, respetando siempre los derechos morales de sus autores. Para lo cual se
    recomienda el uso de la Licencia de Creative Commons http://co.creativecommons.org/tipos-de-licencias/, de igual manera, compartimos link con guía para licenciar los trabajos: http://creativecommons.org/choose/.
    En este sentido, se sugiere utilizar la licencia de la figura 1, ya que el contenido de estos videos está orientado solo a fines académicos y por tanto no se puede hacer uso comercial de estos.
  </p>
  <p style="text-align: justify;" class="marginPdf">
     <calibriBold>Figura 1. Imagen que representa la licencia Creative Commons.</calibriBold>
  </p>
  <br>
  <br>
  <p class="marginPdf">
    <div class="row">
      <div class="center">
        <img src="{{ asset('img/licenciaCC.png') }}" class="img-responsive" height="30%" width="30%">
      </div>
    </div>
  </p>
  <br>
  <br>
  <br>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>UNDÉCIMO. CAUSALES DE SANCIÓN:</calibriBold> El no cumplimiento a los compromisos adquiridos por el Talento dará lugar a sanciones dependiendo de la naturaleza del incumplimiento.
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>DUODÉCIMO. TIPOS DE SANCIÓN:</calibriBold> Dependiendo de la naturaleza del incumplimiento se incurre en los siguientes tipos de sanción:
  </p>


  {{---------------------------------------------------------------------------- INICIO DE LA SEXTA PÁGINA DEL ACUERDO DE CONFIDENCILIDAD Y COMPROMISO ----------------------------------------------------------------------------}}
  <div class="page-break"></div>
  <div class="row">
    <div class="center">
      <img src="{{ asset('img/encabezadoAcc.png') }}" class="img-responsive">
    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <p>
    <ol type="1" style="text-align: justify; margin: 0mm 10mm 0mm 5mm; line-height: 15px;">
      <li>
        <calibriBold>Sanción Leve:</calibriBold> Restricción de acceso a herramientas, laboratorios, equipos especializados y asesorías, además de perder privilegios de horarios, durante un mes.
        Se aplica esta sanción para proyectos que incumplan reiteradamente a las citas y horarios programados con los gestores, que estén incumpliendo con el plan de trabajo injustificadamente y/o para aquellos
        proyectos que no presenten los informes con evidencias de avance.
      </li>
      <li>
        <calibriBold>Restricción temporal a eventos:</calibriBold> Penalización de asistencia a cierto tipo de eventos durante un periodo de tres (3) meses. Aplica para personas que se hayan inscrito en talleres,
        charlas y actividades complementarias y no hayan asistido quitándole el cupo o la oportunidad a otras personas de participar.
      </li>
      <li>
        <calibriBold>Suspensión temporal:</calibriBold> Suspensión de todos los servicios ofrecidos por la Red Tecnoparque SENA, durante un periodo igual a un mes hábil. Será causante de esta sanción el no asistir al
        comité de seguimiento o ausentarse por más de 4 semanas al Nodo sin previa notificación o excusa.
      </li>
      <li>
        <calibriBold>Suspensión:</calibriBold> Cancelación del proyecto. Se presenta por ausentarse de las actividades de la Red Tecnoparque por un periodo superior a un (1) mes sin previa notificación o justificación.
        De la suspensión se puede volver a ser proyecto activo una vez se hayan cumplido seis (6) meses de sanción y se asuman compromisos más fuertes y estrictos que iniciarían con la realización de actividades complementarias
        por parte del suspendido a la comunidad de la Red Tecnoparque SENA.
      </li>
      <li>
        <calibriBold>Expulsión de Tecnoparque:</calibriBold> Suspensión definitiva del Talento/Usuarios y cancelación del proceso de acompañamiento al proyecto. La cual se aplica a los Talentos/Usuarios que presenten
        comportamientos inadecuados, conducta grosera, violenta, discriminatoria, que atente contra las buenas costumbres o que irrespete a la comunidad de la Red Tecnoparque en general ya sea en actividades normales,
        eventos internos o externos en los que participen en nombre del SENA o de la Red. También aplica por intención o ejecución de robo y/o daño con intención a la infraestructura.
      </li>
    </ol>
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>DÉCIMO TERCERO. MODIFICACIÓN O TERMINACIÓN.</calibriBold> Este acuerdo sólo podrá ser modificado o darse por terminado con el consentimiento expreso por escrito de ambas partes antes o en el Acta de Cierre
    del proyecto.
  </p>
  <br>
  <p style="text-align: justify;" class="marginPdf">
    <calibriBold>DÉCIMO CUARTO. FIRMA DEL DOCUMENTO.</calibriBold> Para la firma de este documento en los casos de los menores de edad, este deberá ser avalado y firmado por un acudiente mayor de edad quien también
    firmará el presente acuerdo, aceptando todas las políticas y manuales vigentes de la Red.
  </p>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <p style="text-align: justify" class="marginPdf">
    Para constancia y validez del presente, se firma el documento en la ciudad de <calibriBold>{{ $proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre }}</calibriBold>
    a los <calibriBold>{{ Carbon\Carbon::now()->isoFormat('DD') }}</calibriBold> días del mes de: <calibriBold>{{ Carbon\Carbon::now()->monthName }}</calibriBold> de
    <calibriBold>{{ Carbon\Carbon::now()->isoFormat('YYYY') }}</calibriBold>, por los aceptantes:
  </p>
  {{-- Página de la firma de las partes (gestor, dinamizador, talento líder) --}}
  <div class="page-break"></div>
  <div style="margin: 0mm 10mm 18mm 10mm;">
    <div class="row">
      <div class="center">
        <img src="{{ asset('img/encabezadoAcc.png') }}" class="img-responsive">
      </div>
    </div>
    <br><br><br><br><br><br><br>
    <div class="row" class="marginPdf">
      <div style="border-width: 1px; border-style: solid; border-color: black" class="col title1 center"><calibriBold>REPRESENTANTES DEL PROYECTO</calibriBold></div>
      <div style="border-width: 1px; border-style: solid; border-color: black" class="col title2 center"><calibriBold>RED TECNOPARQUE SENA</calibriBold></div>
    </div>
    <br>
    <div class="row">
      <div style="border-width: 1px; border-style: solid; border-color: black; line-height: 15px;" class="col firmaRep">
        <br>
        Firma: <ylee>{{ $talento_lider->nombre_talento }}</ylee>
        <br>
        {{ $talento_lider->nombre_talento }}
        <br>
        <calibriBold>Nombre del Talento Interlocutor.</calibriBold>
        <br>
        C.C.
        <br>
        {{ $talento_lider->documento }}
      </div>
      <div style="border-width: 1px; border-style: solid; border-color: black; line-height: 15px;" class="col firmaTec">
        <br>
        Firma: <ylee>{{ $gestor->usuario }}</ylee>
        <br><br>
        {{ $gestor->usuario }}
        <br>
        <calibriBold>Nombre del Gestor a cargo de las Asesorías del Proyecto.</calibriBold>
        <br>
        C.C. {{ $gestor->documento }}
        <br>
      </div>
    </div>
    <br><br><br><br><br><br><br>
    <div class="row">
      <div style="border-width: 1px; border-style: solid; border-color: black; line-height: 15px;" class="col firmaRep">
      </div>
      <div style="border-width: 1px; border-style: solid; border-color: black; line-height: 15px;" class="col firmaTec">
        <br>
        Firma: <ylee>{{ $dinamizador->usuario }}</ylee>
        <br><br>
        {{ $dinamizador->usuario }}
        <br>
        <calibriBold>Nombre del Dinamizador del Nodo.</calibriBold>
        <br>
        C.C.
        <br>
        {{ $dinamizador->documento }}
      </div>
    </div>
    <br><br><br><br><br><br><br>
    <div class="row">
      <div style="border-width: 1px; border-style: solid; border-color: black" class="col contenedorGrande">
        Firma Acudiente:
        <br>
        <ylee>{{ Carbon\Carbon::parse($talento_lider->fechanacimiento)->age < 18 ? $proyecto->nombre_acudiente : '' }}</ylee>
        <br>
        <calibriBold>Nombre Acudiente.</calibriBold>
        <br>
        {{ Carbon\Carbon::parse($talento_lider->fechanacimiento)->age < 18 ? $proyecto->nombre_acudiente : '' }}
        <br>
        <calibriBold>C.C.</calibriBold>
        {{ Carbon\Carbon::parse($talento_lider->fechanacimiento)->age < 18 ? $proyecto->cedula_acudiente : '' }}
      </div>
    </div>
    <br><br><br><br><br><br><br>
    <div class="row">
      <div style="border-width: 1px; border-style: solid; border-color: black" class="col contenedorGrande2">
        <calibriBold>Nota:</calibriBold> El talento interlocutor será la persona encargada de comunicarse con el personal Tecnoparque.
        <p style="line-height: 10px">
          Todos los talentos tendrán igualdad de derechos morales y patrimoniales, al menos que se establezca por escrito lo contrario, dicho documento debe ser firmado por todos los integrantes del equipo.
        </p>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
