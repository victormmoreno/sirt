<h3 class="center primary-text">Encuesta de percepción</h3>
<h4 class="center primary-text">Proyecto: {{$proyecto->codigo_proyecto}}</h4>
<div class="card-panel">
    <h5>Estimado Talento.</h5>
    <p>
        Le agradecemos sinceramente su participación en esta encuesta de percepción confidencial que no 
        le llevará más de 5 minutos su diligenciamiento; diseñada para evaluar su experiencia y percepción 
        del Tecnoparque que ha acompañado su proceso. 
        Su retroalimentación es fundamental para ayudarnos a comprender mejor sus necesidades, 
        identificar áreas de mejora y fortalecer nuestro compromiso con el desempeño eficiente en la 
        realización de proyectos.
    </p>
    <br>
    <p>
        Su participación en esta encuesta es completamente confidencial y 
        sus respuestas, serán utilizadas únicamente con fines de análisis interno. 
        Por favor, responda con honestidad y franqueza, ya que sus comentarios son esenciales para 
        ayudarnos a mejorar continuamente en nuestros procesos de innovación, desarrollo tecnológico e 
        investigación.
    </p>
    <br>
    <div class="row">
        <center>
            <div class="input-field col s12 m12 l12">
                <h4 class="black-text"><b>¿Autorizo el tratamiento de la Información?</b></h4>
                <p class="center">
                    <input onclick="divForm.show();" class="with-gap" id="radio_tratamiento1" name="autoriza_tratamiento" type="radio" value="SI">
                    <label for="radio_tratamiento1" class="p-h-md">SI</label>
                </p>
                <p class="center">
                    <input onclick="divForm.hide();" class="with-gap" id="radio_tratamiento2" name="autoriza_tratamiento" type="radio" value="NO">
                    <label for="radio_tratamiento2" class="p-h-md">NO</label>
                </p>
                <small id="autoriza_tratamiento-error" class="p-v-xs error red-text"></small>
            </div>
        </center>
    </div>
    <h6>
        <b>Nota: </b>De acuerdo con La Ley 1581 de 2012, Protección de Datos Personales, el Servicio Nacional de Aprendizaj
        e SENA garantizará la seguridad y protección de los datos personales que se encuentran almacenados en 
        este documento de acuerdo con la clasificación del mismo.
    </h6>
    <br>
    <p>
        Agradecemos sinceramente su tiempo y contribución a este importante esfuerzo. 
    </p>
    <br>
    <p>
        ¡Gracias por ser parte de la Red Tecnoparque Colombia! 
    </p>
    <p>
        Atentamente, 
        <br>
        Dirección de Formación Profesional - SENA. 
    </p>
</div>
<div id="form_content">
    <div class="row card-panel">
        <input type="hidden" name="token_encuesta" value="{{$token}}">
        <input type="hidden" name="proyecto_id" value="{{$proyecto->id}}">
        <h4 class="center-align primary-text">Datos generales</h4>
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text"><b>Estado de su proyecto</b> <span class="red-text">*</span></h6>
            <p>
                <input class="with-gap" name="estado_proyecto" type="radio" id="acompanamiento" value="En acompañamiento">
                <label for="acompanamiento" class="p-h-md">En acompañamiento</label>
            </p>
            <p>
                <input class="with-gap" name="estado_proyecto" type="radio" id="finalizado" value="Finalizado">
                <label for="finalizado" class="p-h-md">Finalizado</label>
            </p>
            <p>
                <input class="with-gap" name="estado_proyecto" type="radio" id="cancelado" value="Cancelado">
                <label for="cancelado" class="p-h-md">Cancelado</label>
            </p>
            <small id="estado_proyecto-error" class="p-v-xs error red-text"></small>
        </div>
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text"><b>Escoja cuál de las siguientes afirmaciones es más afín a las características de su proyecto</b> <span class="red-text">*</span></h6>
            <p>
                <input class="with-gap" id="radio21" name="afinidad_proyecto" type="radio" value="Mi proyecto corresponde a un emprendimiento o desarrollo tecnológico personal con fines lucrativos">
                <label for="radio21" class="p-h-md">Mi proyecto corresponde a un emprendimiento o desarrollo tecnológico personal con fines lucrativos</label>
            </p>
            <p>
                <input class="with-gap" id="radio22" name="afinidad_proyecto" type="radio" value="Mi proyecto corresponde a un emprendimiento o desarrollo tecnológico familiar con fines lucrativos">
                <label for="radio22" class="p-h-md">Mi proyecto corresponde a un emprendimiento o desarrollo tecnológico familiar con fines lucrativos</label>
            </p>
            <p>
                <input class="with-gap" id="radio23" name="afinidad_proyecto" type="radio" value="Mi proyecto corresponde a un emprendimiento o desarrollo tecnológico de una empresa/organización con fines lucrativos">
                <label for="radio23" class="p-h-md">Mi proyecto corresponde a un emprendimiento o desarrollo tecnológico de una empresa/organización con fines lucrativos</label>
            </p>
            <p>
                <input class="with-gap" id="radio24" name="afinidad_proyecto" type="radio" value="Mi proyecto desarrollado corresponde a un interés particular con fines académicos">
                <label for="radio24" class="p-h-md">Mi proyecto desarrollado corresponde a un interés particular con fines académicos</label>
            </p>
            <p>
                <input class="with-gap" id="radio25" name="afinidad_proyecto" type="radio" value="Mi proyecto desarrollado corresponde a un interés particular con fin social sin ánimo de lucro">
                <label for="radio25" class="p-h-md">Mi proyecto desarrollado corresponde a un interés particular con fin social sin ánimo de lucro</label>
            </p>
            <small id="afinidad_proyecto-error" class="p-v-xs error red-text"></small>
        </div>
    </div>
    <div class="row card-panel">
        <h4 class="center-align primary-text">Actores que hicieron parte del proceso</h4>
        <div class="col s12 m12 l12">
            <h6 class="black-text"><b>¿Conoce usted al Infocenter del Tecnoparque que lo atendió?</B <span class="red-text">*</span></h6>
            <div class="switch m-b-md">
                <label>
                    No
                    <input type="checkbox" name="conoce_infocenter" id="conoce_infocenter" value="Si" onchange="showInput_Infocenter()">
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div id="infocenter_content">
            <div class="input-field col s12 m12 l12">
                <h6 class="black-text">
                    <b>Puntúe la amabilidad con la cuál fue atendido por Infocenter donde un (1) 
                    representa la calificación más baja y tres (3) la calificación más alta. 
                    Considere lo siguiente</b> <span class="red-text">*</span>
                </h6>
                {{-- <p class="range-field">
                    <input type="range" id="infocenter_amabilidad" name="infocenter_amabilidad" min="1" max="3" />
                </p> --}}
                <p class="no-p-v">
                    <input class="with-gap " name="infocenter_amabilidad" type="radio"
                        id="infocenter_amabilidad1" value="1">
                    <label for="infocenter_amabilidad1" class="p-h-md">1</label>
                    <input class="with-gap" t name="infocenter_amabilidad" type="radio"
                        id="infocenter_amabilidad2" value="2">
                    <label for="infocenter_amabilidad2" class="p-h-md">2</label>
                    <input class="with-gap" name="infocenter_amabilidad" type="radio"
                        id="infocenter_amabilidad3" value="3">
                    <label for="infocenter_amabilidad3" class="p-h-md">3</label>
                </p>
                <small id="infocenter_amabilidad-error" class="p-v-xs error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <h6 class="black-text">
                    <b>Puntúe el conocimiento demostrado por Infocenter donde uno (1) representa la calificación 
                    más baja y tres (3) la calificación más alta. Considere lo siguiente</b> <span class="red-text">*</span>
                </h6>
                {{-- <p class="range-field">
                    <input type="range" id="infocenter_conocimiento" name="infocenter_conocimiento" min="1" max="3" />
                </p> --}}
                <p class="no-p-v">
                    <input class="with-gap " name="infocenter_conocimiento" type="radio"
                        id="infocenter_conocimiento1" value="1">
                    <label for="infocenter_conocimiento1" class="p-h-md">1</label>
                    <input class="with-gap" t name="infocenter_conocimiento" type="radio"
                        id="infocenter_conocimiento2" value="2">
                    <label for="infocenter_conocimiento2" class="p-h-md">2</label>
                    <input class="with-gap" name="infocenter_conocimiento" type="radio"
                        id="infocenter_conocimiento3" value="3">
                    <label for="infocenter_conocimiento3" class="p-h-md">3</label>
                </p>
                <small id="infocenter_conocimiento-error" class="p-v-xs error red-text"></small>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <h6 class="black-text"><b>¿Conoce usted al Dinamizador@ del Tecnoparque que lo atendió?</b> <span class="red-text">*</span></h6>
            <div class="switch m-b-md">
                <label>
                    No
                    <input type="checkbox" name="conoce_dinamizador" id="conoce_dinamizador" value="Si" onchange="showInput_Dinamizador()">
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div id="dinamizador_content">
            <div class="input-field col s12 m12 l12">
                <h6 class="black-text">
                    <b>Puntúe la amabilidad con la cuál fue atendido por Dinamizador@ donde una (1) 
                    representa la calificación más baja y tres (3) la calificación más alta. 
                    Considere lo siguiente</b> <span class="red-text">*</span>
                </h6>
                {{-- <p class="range-field">
                    <input type="range" id="dinamizador_amabilidad" name="dinamizador_amabilidad" min="1" max="3" />
                </p> --}}
                <p class="no-p-v">
                    <input class="with-gap " name="dinamizador_amabilidad" type="radio"
                        id="dinamizador_amabilidad1" value="1">
                    <label for="dinamizador_amabilidad1" class="p-h-md">1</label>
                    <input class="with-gap" t name="dinamizador_amabilidad" type="radio"
                        id="dinamizador_amabilidad2" value="2">
                    <label for="dinamizador_amabilidad2" class="p-h-md">2</label>
                    <input class="with-gap" name="dinamizador_amabilidad" type="radio"
                        id="dinamizador_amabilidad3" value="3">
                    <label for="dinamizador_amabilidad3" class="p-h-md">3</label>
                </p>
                <small id="dinamizador_amabilidad-error" class="p-v-xs error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <h6 class="black-text">
                    <b>Puntúe el conocimiento demostrado por Dinamizador@ donde uno (1) representa la calificación 
                    más baja y tres (3) la calificación más alta. Considere lo siguiente</b> <span class="red-text">*</span>
                </h6>
                {{-- <p class="range-field">
                    <input type="range" id="dinamizador_conocimiento" name="dinamizador_conocimiento" min="1" max="3" />
                </p> --}}
                <p class="no-p-v">
                    <input class="with-gap " name="dinamizador_conocimiento" type="radio"
                        id="dinamizador_conocimiento1" value="1">
                    <label for="dinamizador_conocimiento1" class="p-h-md">1</label>
                    <input class="with-gap" t name="dinamizador_conocimiento" type="radio"
                        id="dinamizador_conocimiento2" value="2">
                    <label for="dinamizador_conocimiento2" class="p-h-md">2</label>
                    <input class="with-gap" name="dinamizador_conocimiento" type="radio"
                        id="dinamizador_conocimiento3" value="3">
                    <label for="dinamizador_conocimiento3" class="p-h-md">3</label>
                </p>
                <small id="dinamizador_conocimiento-error" class="p-v-xs error red-text"></small>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <h6 class="black-text"><b>¿Conoce usted al Articulador@ del Tecnoparque que lo atendió?</b> <span class="red-text">*</span></h6>
            <div class="switch m-b-md">
                <label>
                    No
                    <input type="checkbox" name="conoce_articulador" id="conoce_articulador" value="Si" onchange="showInput_Articulador()">
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div id="articulador_content">
            <div class="input-field col s12 m12 l12">
                <h6 class="black-text">
                    <b>Puntúe la amabilidad con la cuál fue atendido por Articulador@ donde uno (1) 
                    representa la calificación más baja y tres (3) la calificación más alta. 
                    Considere lo siguiente</b> <span class="red-text">*</span>
                </h6>
                {{-- <p class="range-field">
                    <input type="range" id="articulador_amabilidad" name="articulador_amabilidad" min="1" max="3" />
                </p> --}}
                <p class="no-p-v">
                    <input class="with-gap " name="articulador_amabilidad" type="radio"
                        id="articulador_amabilidad1" value="1">
                    <label for="articulador_amabilidad1" class="p-h-md">1</label>
                    <input class="with-gap" t name="articulador_amabilidad" type="radio"
                        id="articulador_amabilidad2" value="2">
                    <label for="articulador_amabilidad2" class="p-h-md">2</label>
                    <input class="with-gap" name="articulador_amabilidad" type="radio"
                        id="articulador_amabilidad3" value="3">
                    <label for="articulador_amabilidad3" class="p-h-md">3</label>
                </p>
                <small id="articulador_amabilidad-error" class="p-v-xs error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <h6 class="black-text">
                    <b>Puntúe el conocimiento demostrado por Articulador@ donde uno (1) representa la calificación 
                    más baja y tres (3) la calificación más alta. Considere lo siguiente</b> <span class="red-text">*</span>
                </h6>
                {{-- <p class="range-field">
                    <input type="range" id="articulador_conocimiento" name="articulador_conocimiento" min="1" max="3" />
                </p> --}}
                <p class="no-p-v">
                    <input class="with-gap " name="articulador_conocimiento" type="radio"
                        id="articulador_conocimiento1" value="1">
                    <label for="articulador_conocimiento1" class="p-h-md">1</label>
                    <input class="with-gap" t name="articulador_conocimiento" type="radio"
                        id="articulador_conocimiento2" value="2">
                    <label for="articulador_conocimiento2" class="p-h-md">2</label>
                    <input class="with-gap" name="articulador_conocimiento" type="radio"
                        id="articulador_conocimiento3" value="3">
                    <label for="articulador_conocimiento3" class="p-h-md">3</label>
                </p>
                <small id="articulador_conocimiento-error" class="p-v-xs error red-text"></small>
            </div>
        </div>
        {{-- <div class="row"> --}}
            <div class="row col s12 m12 l12">
                <h6 class="black-text">
                    <b>Puntúe la disposición del talento humano del Tecnoparque en general para atender sus 
                    inquietudes donde uno (1) representa la calificación más baja y tres (3) la calificación 
                    más alta. Considere lo siguiente</b> <span class="red-text">*</span>
                </h6>
            </div>
        {{-- </div> --}}
        {{-- <div class="col s12 m5 l5">
            <p class="range-field">
                <input width="50%" type="range" id="disposicion_personal" name="disposicion_personal" min="1" max="3" step="1"/>
            </p>
        </div> --}}
        <p class="no-p-v">
            <input class="with-gap " name="disposicion_personal" type="radio"
                id="disposicion_personal1" value="1">
            <label for="disposicion_personal1" class="p-h-md">1</label>
            <input class="with-gap" t name="disposicion_personal" type="radio"
                id="disposicion_personal2" value="2">
            <label for="disposicion_personal2" class="p-h-md">2</label>
            <input class="with-gap" name="disposicion_personal" type="radio"
                id="disposicion_personal3" value="3">
            <label for="disposicion_personal3" class="p-h-md">3</label>
        </p>
        <small id="disposicion_personal-error" class="p-v-xs error red-text"></small>
        <div class="col s12 m12 l12">
            <h6 class="black-text">
                <b>A continuación, califique las siguientes afirmaciones de acuerdo con su 
                experiencia en el proceso de atención del Tecnoparque</b> <span class="red-text">*</span>
            </h6>
            <table class="striped">
                <thead>
                  <tr>
                      <th width="40%"></th>
                      <th class="center" width="20%">En desacuerdo</th>
                      <th class="center" width="20%">Neutral</th>
                      <th class="center" width="20%">De acuerdo</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Me sentí acompañado y asesorado para enfrentar el Comité de Ideas, reconociendo claramente 
                            cómo debía presentar mi idea y bajo qué parámetros iba a ser evaluado mi proyecto.
                            <br>
                            <small id="acompanamiento_comite-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert111" name="acompanamiento_comite" type="radio" value="En desacuerdo">
                                <label for="likert111"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert112" name="acompanamiento_comite" type="radio" value="Neutral">
                                <label for="likert112"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert113" name="acompanamiento_comite" type="radio" value="De acuerdo">
                                <label for="likert113"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            El Comité de Ideas se desarrolló oportunamente y bajo los parámetros socializados.
                            <br>
                            <small id="desarrollo_comite-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert121" name="desarrollo_comite" type="radio" value="En desacuerdo">
                                <label for="likert121"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert122" name="desarrollo_comite" type="radio" value="Neutral">
                                <label for="likert122"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert123" name="desarrollo_comite" type="radio" value="De acuerdo">
                                <label for="likert123"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            La asignación de mi experto se dió de manera ágil luego de que el Comité de Ideas aprobará mi idea.
                            <br>
                            <small id="asignacion_experto-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert131" name="asignacion_experto" type="radio" value="En desacuerdo">
                                <label for="likert131"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert132" name="asignacion_experto" type="radio" value="Neutral">
                                <label for="likert132"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert133" name="asignacion_experto" type="radio" value="De acuerdo">
                                <label for="likert133"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Realicé la inscripción en plataforma de manera sencilla.
                            <br>
                            <small id="inscripcion_plataforma-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert141" name="inscripcion_plataforma" type="radio" value="En desacuerdo">
                                <label for="likert141"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert142" name="inscripcion_plataforma" type="radio" value="Neutral">
                                <label for="likert142"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert143" name="inscripcion_plataforma" type="radio" value="De acuerdo">
                                <label for="likert143"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Me fue fácil utilizar la plataforma de Tecnoparque pues es una plataforma intuitiva.
                            <br>
                            <small id="uso_plataforma-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert151" name="uso_plataforma" type="radio" value="En desacuerdo">
                                <label for="likert151"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert152" name="uso_plataforma" type="radio" value="Neutral">
                                <label for="likert152"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert153" name="uso_plataforma" type="radio" value="De acuerdo">
                                <label for="likert153"></label>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col s12 m12 l12">
            <h6 class="black-text">
                <b>A continuación, califique las siguientes afirmaciones de acuerdo con su experiencia en 
                el proceso de acompañamiento del Experto de Tecnoparque con el que 
                desarrolló su proyecto</b> <span class="red-text">*</span>
            </h6>
            <table class="striped">
                <thead>
                  <tr>
                      <th width="40%"></th>
                      <th class="center" width="20%">En desacuerdo</th>
                      <th class="center" width="20%">Neutral</th>
                      <th class="center" width="20%">De acuerdo</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            El experto demuestra conocimiento y experiencia en acompañamiento para el desarrollo de proyectos
                            <br>
                            <small id="conocimiento_experto-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert211" name="conocimiento_experto" type="radio" value="En desacuerdo">
                                <label for="likert211"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert212" name="conocimiento_experto" type="radio" value="Neutral">
                                <label for="likert212"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert213" name="conocimiento_experto" type="radio" value="De acuerdo">
                                <label for="likert213"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            El acompañamiento del experto ayudó a lograr los objetivos propuestos.
                            <br>
                            <small id="experto_ayuda_objetivos-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert221" name="experto_ayuda_objetivos" type="radio" value="En desacuerdo">
                                <label for="likert221"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert222" name="experto_ayuda_objetivos" type="radio" value="Neutral">
                                <label for="likert222"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert223" name="experto_ayuda_objetivos" type="radio" value="De acuerdo">
                                <label for="likert223"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            El experto cumple con el cronograma de las actividades planeadas y concertadas previamente.
                            <br>
                            <small id="experto_cumple_cronograma-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert231" name="experto_cumple_cronograma" type="radio" value="En desacuerdo">
                                <label for="likert231"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert232" name="experto_cumple_cronograma" type="radio" value="Neutral">
                                <label for="likert232"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert233" name="experto_cumple_cronograma" type="radio" value="De acuerdo">
                                <label for="likert233"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            El experto realiza seguimiento a las actividades que me han sido asignadas como Talento.
                            <br>
                            <small id="experto_hace_seguimiento-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert241" name="experto_hace_seguimiento" type="radio" value="En desacuerdo">
                                <label for="likert241"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert242" name="experto_hace_seguimiento" type="radio" value="Neutral">
                                <label for="likert242"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert243" name="experto_hace_seguimiento" type="radio" value="De acuerdo">
                                <label for="likert243"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            El experto presenta recursos y ayudas para el desarrollo del proyecto.
                            <br>
                            <small id="experto_presenta_recursos-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert251" name="experto_presenta_recursos" type="radio" value="En desacuerdo">
                                <label for="likert251"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert252" name="experto_presenta_recursos" type="radio" value="Neutral">
                                <label for="likert252"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert253" name="experto_presenta_recursos" type="radio" value="De acuerdo">
                                <label for="likert253"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            El experto entrega documentos para el cierre del proyecto de manera oportuna y eficiente.
                            <br>
                            <small id="experto_entrega_documentos-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert261" name="experto_entrega_documentos" type="radio" value="En desacuerdo">
                                <label for="likert261"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert262" name="experto_entrega_documentos" type="radio" value="Neutral">
                                <label for="likert262"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert263" name="experto_entrega_documentos" type="radio" value="De acuerdo">
                                <label for="likert263"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            El experto demuestra calidad, responsabilidad, puntualidad y motivación en el acompañamiento del proyecto.
                            <br>
                            <small id="experto_acompana-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert271" name="experto_acompana" type="radio" value="En desacuerdo">
                                <label for="likert271"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert272" name="experto_acompana" type="radio" value="Neutral">
                                <label for="likert272"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert273" name="experto_acompana" type="radio" value="De acuerdo">
                                <label for="likert273"></label>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col s12 m12 l12">
            <h6 class="black-text">
                <b>A continuación, califique las siguientes afirmaciones de acuerdo con su percepción 
                sobre la infraestructura física y tecnológica del Tecnoparque con el que 
                desarrolló su proyecto</b> <span class="red-text">*</span>
            </h6>
            <table class="striped">
                <thead>
                  <tr>
                      <th width="40%"></th>
                      <th class="center" width="20%">En desacuerdo</th>
                      <th class="center" width="20%">Neutral</th>
                      <th class="center" width="20%">De acuerdo</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            La infraestructura tecnológica del Tecnoparque es acorde a las necesidades de desarrollo de mi proyecto.
                            <br>
                            <small id="infraestructura_acorde_necesidades-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert311" name="infraestructura_acorde_necesidades" type="radio" value="En desacuerdo">
                                <label for="likert311"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert312" name="infraestructura_acorde_necesidades" type="radio" value="Neutral">
                                <label for="likert312"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert313" name="infraestructura_acorde_necesidades" type="radio" value="De acuerdo">
                                <label for="likert313"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Existía la disponibilidad física (de sillas, mesas, maquinaría, iluminación, ventilación, 
                            entre otras condiciones) adecuada en el Tecnoparque para el desarrollo de mi proyecto.
                            <br>
                            <small id="infraestructura_disponibilidad-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert321" name="infraestructura_disponibilidad" type="radio" value="En desacuerdo">
                                <label for="likert321"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert322" name="infraestructura_disponibilidad" type="radio" value="Neutral">
                                <label for="likert322"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert323" name="infraestructura_disponibilidad" type="radio" value="De acuerdo">
                                <label for="likert323"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Los materiales utilizados estuvieron disponibles y me ayudaron en el logro de mi proyecto.
                            <br>
                            <small id="materiales_disponibilidad-error" class="p-v-xs error red-text"></small>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert331" name="materiales_disponibilidad" type="radio" value="En desacuerdo">
                                <label for="likert331"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert332" name="materiales_disponibilidad" type="radio" value="Neutral">
                                <label for="likert332"></label>
                            </p>
                        </td>
                        <td>
                            <p class="center">
                                <input class="with-gap" id="likert333" name="materiales_disponibilidad" type="radio" value="De acuerdo">
                                <label for="likert333"></label>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text"><b>¿Recibió acompañamiento del Articulador del Tecnoparque que lo atendió?</b> <span class="red-text">*</span></h6>
            <p>
                <input class="with-gap" id="radio31" name="acompanamiento_articulador" type="radio" onclick="javascript:void(0); divArticuladorAcompanamiento.show()" value="Sí lo necesitaba y recibí acompañamiento en mi proyecto">
                <label for="radio31" class="p-h-md">Sí lo necesitaba y recibí acompañamiento en mi proyecto</label>
            </p>
            <p>
                <input class="with-gap" id="radio32" name="acompanamiento_articulador" type="radio" onclick="javascript:void(0); divArticuladorAcompanamiento.show()" value="Si lo necesitaba, pero no recibí atención por parte de articulador a pesar de solicitarlo">
                <label for="radio32" class="p-h-md">Si lo necesitaba, pero no recibí atención por parte de articulador a pesar de solicitarlo</label>
            </p>
            <p>
                <input class="with-gap" id="radio33" name="acompanamiento_articulador" type="radio" onclick="javascript:void(0); divArticuladorAcompanamiento.hide()" value="Mi proyecto no lo requería">
                <label for="radio33" class="p-h-md">Mi proyecto no lo requería</label>
            </p>
            <p>
                <input class="with-gap" id="radio34" name="acompanamiento_articulador" type="radio" onclick="javascript:void(0); divArticuladorAcompanamiento.hide()" value="No conozco el servicio que ofrece el articulador del Tecnoparque">
                <label for="radio34" class="p-h-md">No conozco el servicio que ofrece el articulador del Tecnoparque</label>
            </p>
            <small id="acompanamiento_articulador-error" class="p-v-xs error red-text"></small>
        </div>
        <div id="articulador_acompanamiento_content">
            <div class="col s12 m12 l12">
                <h6 class="black-text">
                    <b>A continuación, califique las siguientes afirmaciones de acuerdo con el acompañamiento recibido por 
                    parte de Articulador del Tecnoparque con el que desarrolló su proyecto</b> <span class="red-text">*</span>
                </h6>
                <table class="striped">
                    <thead>
                      <tr>
                          <th width="40%"></th>
                          <th class="center" width="20%">En desacuerdo</th>
                          <th class="center" width="20%">Neutral</th>
                          <th class="center" width="20%">De acuerdo</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                La articulación realizada alcanzó el propósito que buscaba.
                                <br>
                                <small id="articulacion_alcanza_proposito-error" class="p-v-xs error red-text"></small>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert411" name="articulacion_alcanza_proposito" type="radio" value="En desacuerdo">
                                    <label for="likert411"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert412" name="articulacion_alcanza_proposito" type="radio" value="Neutral">
                                    <label for="likert412"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert413" name="articulacion_alcanza_proposito" type="radio" value="De acuerdo">
                                    <label for="likert413"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                La articulación ha sido fundamental para darle mayor alcance a mi proyecto.
                                <br>
                                <small id="articulacion_fue_fundamental-error" class="p-v-xs error red-text"></small>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert421" name="articulacion_fue_fundamental" type="radio" value="En desacuerdo">
                                    <label for="likert421"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert422" name="articulacion_fue_fundamental" type="radio" value="Neutral">
                                    <label for="likert422"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert423" name="articulacion_fue_fundamental" type="radio" value="De acuerdo">
                                    <label for="likert423"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                El articulador demuestra conocimiento y experiencia frente a la convocatoria y/o actor articulado.
                                <br>
                                <small id="articulador_es_capaz-error" class="p-v-xs error red-text"></small>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert431" name="articulador_es_capaz" type="radio" value="En desacuerdo">
                                    <label for="likert431"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert432" name="articulador_es_capaz" type="radio" value="Neutral">
                                    <label for="likert432"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert433" name="articulador_es_capaz" type="radio" value="De acuerdo">
                                    <label for="likert433"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                El articulador realiza seguimiento a las actividades que me han sido asignadas como Talento.
                                <br>
                                <small id="articulador_hace_seguimiento-error" class="p-v-xs error red-text"></small>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert441" name="articulador_hace_seguimiento" type="radio" value="En desacuerdo">
                                    <label for="likert441"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert442" name="articulador_hace_seguimiento" type="radio" value="Neutral">
                                    <label for="likert442"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert443" name="articulador_hace_seguimiento" type="radio" value="De acuerdo">
                                    <label for="likert443"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                El articulador presenta recursos y ayudas para el desarrollo de la articulación requerida.
                                <br>
                                <small id="articulador_presenta_recursos-error" class="p-v-xs error red-text"></small>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert451" name="articulador_presenta_recursos" type="radio" value="En desacuerdo">
                                    <label for="likert451"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert452" name="articulador_presenta_recursos" type="radio" value="Neutral">
                                    <label for="likert452"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert453" name="articulador_presenta_recursos" type="radio" value="De acuerdo">
                                    <label for="likert453"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                El articulador demuestra calidad, responsabilidad, puntualidad y motivación en el acompañamiento del proyecto.
                                <br>
                                <small id="articulador_demuestra_acompanamiento-error" class="p-v-xs error red-text"></small>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert461" name="articulador_demuestra_acompanamiento" type="radio" value="En desacuerdo">
                                    <label for="likert461"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert462" name="articulador_demuestra_acompanamiento" type="radio" value="Neutral">
                                    <label for="likert462"></label>
                                </p>
                            </td>
                            <td>
                                <p class="center">
                                    <input class="with-gap" id="likert463" name="articulador_demuestra_acompanamiento" type="radio" value="De acuerdo">
                                    <label for="likert463"></label>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <h6 class="black-text"><b>¿Tuve que compartir mi clave de plataforma Tecnoparque con algún otro actor?</B <span class="red-text">*</span></h6>
            <div class="switch m-b-md">
                <label>
                    No
                    <input type="checkbox" name="comparte_credenciales" id="comparte_credenciales" value="Si" onchange="showInput_CompartirCredenciales()">
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div id="credenciales_content">
            <div class="input-field col s12 m12 l12">
                <h6 class="black-text"><b>¿Con quién tuve que compartir mi clave Tecnoparque?</b> <span class="red-text">*</span></h6>
                <p>
                    <input class="with-gap" id="radio41" name="con_quien_comparte" type="radio" value="Familiar, amigo, persona de confianza">
                    <label for="radio41" class="p-h-md">Familiar, amigo, persona de confianza</label>
                </p>
                <p>
                    <input class="with-gap" id="radio42" name="con_quien_comparte" type="radio" value="Dinamizador Tecnoparque">
                    <label for="radio42" class="p-h-md">Dinamizador Tecnoparque</label>
                </p>
                <p>
                    <input class="with-gap" id="radio43" name="con_quien_comparte" type="radio" value="Experto Tecnoparque">
                    <label for="radio43" class="p-h-md">Experto Tecnoparque</label>
                </p>
                <p>
                    <input class="with-gap" id="radio44" name="con_quien_comparte" type="radio" value="Apoyo Técnico Tecnoparque">
                    <label for="radio44" class="p-h-md">Apoyo Técnico Tecnoparque</label>
                </p>
                <p>
                    <input class="with-gap" id="radio45" name="con_quien_comparte" type="radio" value="Infocenter Tecnoparque">
                    <label for="radio45" class="p-h-md">Infocenter Tecnoparque</label>
                </p>
                <p>
                    <input class="with-gap" id="radio46" name="con_quien_comparte" type="radio" value="Articulador Tecnoparque">
                    <label for="radio46" class="p-h-md">Articulador Tecnoparque</label>
                </p>
                <small id="con_quien_comparte-error" class="p-v-xs error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <input type="text" id="motivo_compartir_credenciales" name="motivo_compartir_credenciales" style="border-color: green" value="">
                <label for="motivo_compartir_credenciales">Explique de manera breve los motivos por los cuales ha tenido que 
                    compartir su clave de acceso a la plataforma Tecnoparque</label>
                <small id="motivo_compartir_credenciales-error" class="error red-text"></small>
            </div>
        </div>
        <div class="input-field col s12 m12 l12">
            <input type="text" id="aspectos_a_mejorar" name="aspectos_a_mejorar" style="border-color: green" value="">
            <label for="aspectos_a_mejorar">¿Qué aspectos considera deba mejorar el Tecnoparque en el que fue atendido?</label>
            <small id="aspectos_a_mejorar-error" class="error red-text"></small>
        </div>
        <div class="col s12 m12 l12">
            <h6 class="black-text"><b>¿Alcanzo los resultados u objetivos previstos en el desarrollo y finalización de su proyecto?</B <span class="red-text">*</span></h6>
            <div class="switch m-b-md">
                <label>
                    No
                    <input type="checkbox" name="alcanza_objetivos" id="alcanza_objetivos" value="Si" onchange="showInput_AlcanzaObjetivos()">
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div id="alcanza_objetivo_content">
            <div class="input-field col s12 m12 l12">
                <input type="text" id="motivo_no_logrado" name="motivo_no_logrado" style="border-color: green" value="">
                <label for="motivo_no_logrado">Describa de manera breve el por qué no se logró 
                    alcanzar los objetivos previstos en el desarrollo y finalización de su proyecto</label>
                <small id="motivo_no_logrado-error" class="error red-text"></small>
            </div>
        </div>
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text"><b>¿Cómo se enteró de la Red Tecnoparque del Servicio Nacional de Aprendizaje -SENA?</b> <span class="red-text">*</span></h6>

            <p>
                <input class="with-gap" id="radio51" name="como_conoce_tecnoparque" type="radio" value="Por un amigo">
                <label for="radio51" class="p-h-md">Por un amigo</label>
            </p>
            <p>
                <input class="with-gap" id="radio52" name="como_conoce_tecnoparque" type="radio" value="Por las redes sociales">
                <label for="radio52" class="p-h-md">Por las redes sociales</label>
            </p>
            <p>
                <input class="with-gap" id="radio53" name="como_conoce_tecnoparque" type="radio" value="Por WhatsApp">
                <label for="radio53" class="p-h-md">Por WhatsApp</label>
            </p>
            <p>
                <input class="with-gap" id="radio54" name="como_conoce_tecnoparque" type="radio" value="Por la página del SENA">
                <label for="radio54" class="p-h-md">Por la página del SENA</label>
            </p>
            <small id="como_conoce_tecnoparque-error" class="p-v-xs error red-text"></small>
        </div>
        <div class="col s12 m12 l12">
            <h6 class="black-text"><b>¿Ha utilizado otros servicios del SENA en el proyecto que ha desarrollado?</B <span class="red-text">*</span></h6>
            <div class="switch m-b-md">
                <label>
                    No
                    <input type="checkbox" name="usa_otros_servicios" id="usa_otros_servicios" value="Si" onchange="showInput_OtrosServicios()">
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div id="otros_servicios_content">
            <div class="input-field col s12 m12 l12">
                <h6 class="black-text"><b>Indique qué otros servicios del SENA utilizó o está utilizando para el desarrollo de su proyecto que ha desarrollado</b> <span class="red-text">*</span></h6>
                <p>
                    <input class="with-gap" id="radio61" name="uso_otros_servicios" type="radio" value="Pruebas de Servicios Tecnológicos">
                    <label for="radio61" class="p-h-md">Pruebas de Servicios Tecnológicos</label>
                </p>
                <p>
                    <input class="with-gap" id="radio62" name="uso_otros_servicios" type="radio" value="Extensionismo Tecnológico (MiPymes se transforma)">
                    <label for="radio62" class="p-h-md">Extensionismo Tecnológico (MiPymes se transforma)</label>
                </p>
                <p>
                    <input class="with-gap" id="radio63" name="uso_otros_servicios" type="radio" value="Fondo Emprender">
                    <label for="radio63" class="p-h-md">Fondo Emprender</label>
                </p>
                <p>
                    <input class="with-gap" id="radio64" name="uso_otros_servicios" type="radio" value="Cursos cortos del SENA">
                    <label for="radio64" class="p-h-md">Cursos cortos del SENA</label>
                </p>
                <p>
                    <div class="col s12 m3 l3">
                        <input class="with-gap" id="radio65" name="uso_otros_servicios" type="radio" value="Otras">
                        <label for="radio65" class="p-h-md">Otras</label>
                    </div>
                    <div class="col s12 m9 l9">
                        <input type="text" id="otros_servicios" name="otros_servicios" placeholder="Indique qué otros servicios del SENA utilizó o está utilizando para el desarrollo de su proyecto que ha desarrollado" style="border-color: green" value="">
                        <small id="otros_servicios-error" class="error red-text"></small>
                    </div>
                </p>
                <small id="uso_otros_servicios-error" class="error red-text"></small>
            </div>
        </div>
    </div>
</div>
