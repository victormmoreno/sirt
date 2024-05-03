{{-- 

Campos
estado_proyecto
afinidad_proyecto
conoce_infocenter
infocenter_amabilidad
infocenter_conocimiento
conoce_dinamizador
dinamizador_amabilidad
dinamizador_conocimiento
conoce_articulador
articulador_amabilidad
articulador_conocimiento
dispocision_personal
acompanamiento_comite
desarrollo_comite
conocimiento_experto
experto_ayuda_objetivos
experto_cumple_cronograma
experto_hace_seguimiento
experto_presenta_recursos
experto_entrega_documentos
experto_acompana
infraestructura_acorde_necesidades
infraestructura_disponibilidad
materiales_disponibilidad
 --}}

<div class="row card-panel">
    <h4 class="center-align primary-text">Datos generales</h4>
    <div class="input-field col s12 m12 l12">
        <h6 class="black-text">1. Estado de su proyecto <span class="red-text">*</span></h6>
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
        <h6 class="black-text">2. Escoja cuál de las siguientes afirmaciones es más afín a las características de su proyecto <span class="red-text">*</span></h6>
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
        <h6 class="black-text">3. ¿Conoce usted al Infocenter del Tecnoparque que lo atendió? <span class="red-text">*</span></h6>
        <div class="switch m-b-md">
            <label>
                No
                <input type="checkbox" name="conoce_infocenter" id="conoce_infocenter" value="1" onchange="showInput_Infocenter()">
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
    <div id="infocenter_content">
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text">
                Puntúe la amabilidad con la cuál fue atendido por Infocenter donde una (1) 
                estrella representa la calificación más baja y tres (3) estrellas la calificación más alta. 
                Considere lo siguiente<span class="red-text">*</span>
            </h6>
            <p class="range-field">
                <input type="range" id="infocenter_amabilidad" name="infocenter_amabilidad" min="1" max="3" />
            </p>
        </div>
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text">
                Puntúe el conocimiento demostrado por Infocenter donde una (1) estrella representa la calificación 
                más baja y tres (3) estrellas la calificación más alta. Considere lo siguiente <span class="red-text">*</span>
            </h6>
            <p class="range-field">
                <input type="range" id="infocenter_conocimiento" name="infocenter_conocimiento" min="1" max="3" />
            </p>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <h6 class="black-text">4. ¿Conoce usted al Dinamizador@ del Tecnoparque que lo atendió? <span class="red-text">*</span></h6>
        <div class="switch m-b-md">
            <label>
                No
                <input type="checkbox" name="conoce_dinamizador" id="conoce_dinamizador" value="1" onchange="showInput_Dinamizador()">
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
    <div id="dinamizador_content">
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text">
                Puntúe la amabilidad con la cuál fue atendido por Dinamizador@ donde una (1) 
                estrella representa la calificación más baja y tres (3) estrellas la calificación más alta. 
                Considere lo siguiente<span class="red-text">*</span>
            </h6>
            <p class="range-field">
                <input type="range" id="dinamizador_amabilidad" name="dinamizador_amabilidad" min="1" max="3" />
            </p>
        </div>
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text">
                Puntúe el conocimiento demostrado por Dinamizador@ donde una (1) estrella representa la calificación 
                más baja y tres (3) estrellas la calificación más alta. Considere lo siguiente <span class="red-text">*</span>
            </h6>
            <p class="range-field">
                <input type="range" id="dinamizador_conocimiento" name="dinamizador_conocimiento" min="1" max="3" />
            </p>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <h6 class="black-text">4. ¿Conoce usted al Articulador@ del Tecnoparque que lo atendió? <span class="red-text">*</span></h6>
        <div class="switch m-b-md">
            <label>
                No
                <input type="checkbox" name="conoce_articulador" id="conoce_articulador" value="1" onchange="showInput_Articulador()">
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
    <div id="articulador_content">
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text">
                Puntúe la amabilidad con la cuál fue atendido por Articulador@ donde una (1) 
                estrella representa la calificación más baja y tres (3) estrellas la calificación más alta. 
                Considere lo siguiente<span class="red-text">*</span>
            </h6>
            <p class="range-field">
                <input type="range" id="articulador_amabilidad" name="articulador_amabilidad" min="1" max="3" />
            </p>
        </div>
        <div class="input-field col s12 m12 l12">
            <h6 class="black-text">
                Puntúe el conocimiento demostrado por Articulador@ donde una (1) estrella representa la calificación 
                más baja y tres (3) estrellas la calificación más alta. Considere lo siguiente <span class="red-text">*</span>
            </h6>
            <p class="range-field">
                <input type="range" id="articulador_conocimiento" name="articulador_conocimiento" min="1" max="3" />
            </p>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <h6 class="black-text">5. Puntúe la disposición del talento humano del Tecnoparque en general para atender sus 
            inquietudes donde una (1) estrella representa la calificación más baja y tres (3) estrellas la calificación 
            más alta. Considere lo siguiente <span class="red-text">*</span>
        </h6>
        <p class="range-field">
            <input type="range" id="dispocision_personal" name="dispocision_personal" min="1" max="3" />
        </p>
    </div>
    <div class="col s12 m12 l12">
        <h6 class="black-text">6. A continuación, califique las siguientes afirmaciones de acuerdo con su 
            experiencia en el proceso de atención del Tecnoparque <span class="red-text">*</span>
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
                    <td>El Comité de Ideas se desarrolló oportunamente y bajo los parámetros socializados.</td>
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
                    <td>La asignación de mi experto se dió de manera ágil luego de que el Comité de Ideas aprobará mi idea.</td>
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
                    <td>Realicé la inscripción en plataforma de manera sencilla.</td>
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
                    <td>Me fue fácil utilizar la plataforma de Tecnoparque pues es una plataforma intuitiva.</td>
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
        <h6 class="black-text">7. A continuación, califique las siguientes afirmaciones de acuerdo con su experiencia en 
            el proceso de acompañamiento del Experto de Tecnoparque con el que 
            desarrolló su proyecto <span class="red-text">*</span>
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
                    <td>El acompañamiento del experto ayudó a lograr los objetivos propuestos.</td>
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
                    <td>El experto cumple con el cronograma de las actividades planeadas y concertadas previamente.</td>
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
                    <td>El experto realiza seguimiento a las actividades que me han sido asignadas como Talento.</td>
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
                    <td>El experto presenta recursos y ayudas para el desarrollo del proyecto.</td>
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
                    <td>El experto entrega documentos de seguimiento en el desarrollo del proyecto de manera oportuna y eficiente.</td>
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
                    <td>El experto demuestra calidad, responsabilidad, puntualidad y motivación en el acompañamiento del proyecto.</td>
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
        <h6 class="black-text">8. A continuación, califique las siguientes afirmaciones de acuerdo con su percepción 
            sobre la infraestructura física y tecnológica del Tecnoparque con el que 
            desarrolló su proyecto <span class="red-text">*</span>
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
                    <td>Existía la disponibilidad física (de sillas, mesas, maquinaría, iluminación, ventilación, entre otras condiciones) adecuada en el Tecnoparque para el desarrollo de mi proyecto.</td>
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
                    <td>Los materiales utilizados estuvieron disponibles y me ayudaron en el logro del mi proyecto.</td>
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
</div>