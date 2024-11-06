<table>
    <thead>
    <tr>
        <th>Nodo</th>
        <th>Código de proyecto</th>
        <th>Nombre del proyecto</th>
        <th>Fase actual del proyecto</th>
        <th>Fecha de envío de encuesta</th>
        <th>Fecha de respuesta de la encuesta</th>
        <th>Estado del proyecto</th>
        <th>Características del proyecto</th>
        <th>¿Conoce al infocenter?</th>
        <th>Puntos sobre la amabilidad del infocenter</th>
        <th>Puntos sobre el conocimiento demostrado por el infocenter</th>
        <th>¿Conoce al dinamizador?</th>
        <th>Puntos sobre la amabilidad del dinamizador</th>
        <th>Puntos sobre el conocimiento demostrado por el dinamizador</th>
        <th>¿Conoce al articulador/a?</th>
        <th>Puntos sobre la amabilidad del articulador/a</th>
        <th>Puntos sobre el conocimiento demostrado por el articulador/a</th>
        <th>Puntos sobre la disposición del talento humano del Tecnoparque en general para atender las inquietudes</th>
        <th>Se sintió acompañado y asesorado para enfrentar el Comité de Ideas</th>
        <th>El Comité de Ideas se desarrolló oportunamente y bajo los parámetros socializados</th>
        <th>La asignación del experto se dió de manera ágil luego de que el Comité de Ideas aprobará la idea</th>
        <th>Realizó la inscripción en plataforma de manera sencilla</th>
        <th>Le fue fácil utilizar la plataforma de Tecnoparque</th>
        <th>El experto demuestra conocimiento y experiencia en acompañamiento para el desarrollo de proyectos</th>
        <th>El acompañamiento del experto ayudó a lograr los objetivos propuestos</th>
        <th>El experto cumple con el cronograma de las actividades planeadas y concertadas previamente</th>
        <th>El experto realiza seguimiento a las actividades que le ha asignado al Talento</th>
        <th>El experto presenta recursos y ayudas para el desarrollo del proyecto</th>
        <th>El experto entrega documentos de seguimiento en el desarrollo del proyecto de manera oportuna y eficiente</th>
        <th>El experto demuestra calidad, responsabilidad, puntualidad y motivación en el acompañamiento del proyecto</th>
        <th>La infraestructura tecnológica del Tecnoparque es acorde a las necesidades de desarrollo del proyecto</th>
        <th>Existía la disponibilidad física adecuada en el Tecnoparque para el desarrollo del proyecto</th>
        <th>Los materiales utilizados estuvieron disponibles y ayudaron en el logro del proyecto</th>
        <th>¿Recibió acompañamiento del Articulador del Tecnoparque que lo atendió?</th>
        <th>La articulación realizada alcanzó el propósito que buscaba</th>
        <th>La articulación ha sido fundamental para darle mayor alcance al proyecto</th>
        <th>El articulador demuestra conocimiento y experiencia frente a la convocatoria y/o actor articulado</th>
        <th>El articulador realiza seguimiento a las actividades quele ha asignado al Talento</th>
        <th>El articulador presenta recursos y ayudas para el desarrollo de la articulación requerida</th>
        <th>El articulador demuestra calidad, responsabilidad, puntualidad y motivación en el acompañamiento del proyecto</th>
        <th>¿Tuvo que compartir la clave de plataforma Tecnoparque con algún otro actor?</th>
        <th>¿Con quién tuvo que compartir la clave Tecnoparque?</th>
        <th>Motivos por los cuales ha tenido que compartir la clave de acceso a la plataforma Tecnoparque</th>
        <th>¿Qué aspectos considera deba mejorar el Tecnoparque en el que fue atendido?</th>
        <th>¿Alcanzó los resultados u objetivos previstos en el desarrollo y finalización del proyecto?</th>
        <th>¿Por qué no se logró alcanzar los objetivos previstos en el desarrollo y finalización del proyecto</th>
        <th>¿Cómo se enteró de la Red Tecnoparque del Servicio Nacional de Aprendizaje -SENA?</th>
        <th>¿Ha utilizado otros servicios del SENA en el proyecto que se ha desarrollado?</th>
        <th>¿Qué otros servicios del SENA utilizó o está utilizando para el desarrollo de su proyecto que se ha desarrollado</th>
        <th>Otros servicios del SENA que utilizó o se está utilizando para el desarrollo del proyecto</th>
    </tr>
    </thead>
    <tbody>
        @foreach($resultados as $resultado)
        <tr>
            <td>{{ $resultado->nodo }}</td>
            <td>{{ $resultado->codigo_proyecto }}</td>
            <td>{{ $resultado->nombre_proyecto }}</td>
            <td>{{ $resultado->fase_proyecto }}</td>
            <td>{{ $resultado->fecha_envio }}</td>
            <td>{{ $resultado->fecha_respuesta }}</td>
            <td>{{ $resultado->resultados['estado_proyecto'] }}</td>
            <td>{{ $resultado->resultados['afinidad_proyecto'] }}</td>
            <td>{{ $resultado->resultados['infocenter']['conoce_infocenter'] }}</td>
            <td>{{ $resultado->resultados['infocenter']['infocenter_amabilidad'] }}</td>
            <td>{{ $resultado->resultados['infocenter']['infocenter_conocimiento'] }}</td>
            <td>{{ $resultado->resultados['dinamizador']['conoce_dinamizador'] }}</td>
            <td>{{ $resultado->resultados['dinamizador']['dinamizador_amabilidad'] }}</td>
            <td>{{ $resultado->resultados['dinamizador']['dinamizador_conocimiento'] }}</td>
            <td>{{ $resultado->resultados['articulador']['conoce_articulador'] }}</td>
            <td>{{ $resultado->resultados['articulador']['articulador_amabilidad'] }}</td>
            <td>{{ $resultado->resultados['articulador']['articulador_conocimiento'] }}</td>
            <td>{{ $resultado->resultados['disposicion_personal'] }}</td>
            <td>{{ $resultado->resultados['experiencia_proceso_atencion']['acompanamiento_comite'] }}</td>
            <td>{{ $resultado->resultados['experiencia_proceso_atencion']['desarrollo_comite'] }}</td>
            <td>{{ $resultado->resultados['experiencia_proceso_atencion']['asignacion_experto'] }}</td>
            <td>{{ $resultado->resultados['experiencia_proceso_atencion']['inscripcion_plataforma'] }}</td>
            <td>{{ $resultado->resultados['experiencia_proceso_atencion']['uso_plataforma'] }}</td>
            <td>{{ $resultado->resultados['calificacion_experto']['conocimiento_experto'] }}</td>
            <td>{{ $resultado->resultados['calificacion_experto']['experto_ayuda_objetivos'] }}</td>
            <td>{{ $resultado->resultados['calificacion_experto']['experto_cumple_cronograma'] }}</td>
            <td>{{ $resultado->resultados['calificacion_experto']['experto_hace_seguimiento'] }}</td>
            <td>{{ $resultado->resultados['calificacion_experto']['experto_presenta_recursos'] }}</td>
            <td>{{ $resultado->resultados['calificacion_experto']['experto_entrega_documentos'] }}</td>
            <td>{{ $resultado->resultados['calificacion_experto']['experto_acompana'] }}</td>
            <td>{{ $resultado->resultados['calificacion_infraestructura']['infraestructura_acorde_necesidades'] }}</td>
            <td>{{ $resultado->resultados['calificacion_infraestructura']['infraestructura_disponibilidad'] }}</td>
            <td>{{ $resultado->resultados['calificacion_infraestructura']['materiales_disponibilidad'] }}</td>
            <td>{{ $resultado->resultados['acompanamiento_articulacion']['acompanamiento_articulador'] }}</td>
            <td>{{ $resultado->resultados['acompanamiento_articulacion']['articulacion_alcanza_proposito'] }}</td>
            <td>{{ $resultado->resultados['acompanamiento_articulacion']['articulacion_fue_fundamental'] }}</td>
            <td>{{ $resultado->resultados['acompanamiento_articulacion']['articulador_es_capaz'] }}</td>
            <td>{{ $resultado->resultados['acompanamiento_articulacion']['articulador_hace_seguimiento'] }}</td>
            <td>{{ $resultado->resultados['acompanamiento_articulacion']['articulador_presenta_recursos'] }}</td>
            <td>{{ $resultado->resultados['acompanamiento_articulacion']['articulador_demuestra_acompanamiento'] }}</td>
            <td>{{ $resultado->resultados['usuario_compartido']['comparte_credenciales'] }}</td>
            <td>{{ $resultado->resultados['usuario_compartido']['con_quien_comparte'] }}</td>
            <td>{{ $resultado->resultados['usuario_compartido']['motivo_compartir_credenciales'] }}</td>
            <td>{{ $resultado->resultados['aspectos_a_mejorar'] }}</td>
            <td>{{ $resultado->resultados['objetivos_proyecto']['alcanza_objetivos'] }}</td>
            <td>{{ $resultado->resultados['objetivos_proyecto']['motivo_no_logrado'] }}</td>
            <td>{{ $resultado->resultados['como_conoce_tecnoparque'] }}</td>
            <td>{{ $resultado->resultados['otros_servicios_sena']['usa_otros_servicios'] }}</td>
            <td>{{ $resultado->resultados['otros_servicios_sena']['uso_otros_servicios'] }}</td>
            <td>{{ $resultado->resultados['otros_servicios_sena']['otros_servicios'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
