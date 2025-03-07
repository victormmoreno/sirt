<div class="modal" id="entidadesTecnoparque_modProyecto_modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <table id="entidadesTecnoparque_proyecto_table" style="width: 100%" class="centered">
                    <thead class="bg-primary white-text">
                        <th>Identificador de la entidad</th>
                        <th>Nombre de la entidad</th>
                        <th>Seleccionar para asociar a proyecto</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" onclick="volverSiElegirEntidad();"
            class="modal-close waves-effect waves-primary btn-flat">Cancelar</a>
    </div>
</div>

<div class="modal" id="posiblesPropietarios_Personas_modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <table id="posiblesPropietarios_Personas_table" style="width: 100%" class="centered">
                    <thead class="bg-primary white-text">
                        <th>Documento de Identidad</th>
                        <th>Nombres del Usuario</th>
                        <th>Asociar como dueño de la propiedad intelectual</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-primary btn-flat">Cerrar</a>
    </div>
</div>

<div class="modal" id="posiblesPropietarios_Empresas_modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <table id="posiblesPropietarios_Empresas_table" style="width: 100%" class="centered">
                    <thead class="bg-primary white-text">
                        <th>Nit</th>
                        <th>Nombre de la Empresa</th>
                        <th>Asociar como dueño de la propiedad intelectual</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
    </div>
</div>

<div class="modal" id="sedesPropietarias_Empresas_modal">
    <div class="modal-content">
        <div class="row">
            <h4>Sedes de la empresa</h4>
            <ul class="collection" id="sedesPropietarias_Empresas_detalles">

            </ul>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-primary btn-flat">Cerrar</a>
    </div>
</div>

<div class="modal" id="posiblesPropietarios_Grupos_modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <table id="posiblesPropietarios_Grupos_table" style="width: 100%" class="centered">
                    <thead class="bg-primary white-text">
                        <th>Código del Grupo</th>
                        <th>Nombre del Grupo</th>
                        <th>Asociar como dueño de la propiedad intelectual</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-primary btn-flat">Cerrar</a>
    </div>
</div>

<div class="modal" id="ideasDeProyectoConEmprendedores_modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <table id="ideasDeProyectoConEmprendedores_proyecto_table" style="width: 100%" class="centered">
                    <thead class="bg-primary white-text">
                        <th>Código de la Idea de Proyecto</th>
                        <th>Nombre de la Idea</th>
                        <th>Nombres del Contacto</th>
                        <th>Seleccionar para asociar a proyecto</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-primary btn-flat">Cancelar</a>
    </div>
</div>

<div class="modal" id="ideasDeProyectoConEmpresasGrupos_modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <table id="ideasDeProyectoConEmpresasGrupos_proyecto_table" style="width: 100%" class="centered">
                    <thead class="bg-primary white-text">
                        <th>Nombre de la Idea</th>
                        <th>Nombres del Contacto</th>
                        <th>Seleccionar para asociar a proyecto</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-primary btn-flat">Cancelar</a>
    </div>
</div>

<div id="modalInformacioTalentosQueDesarrollaranElProyecto" class="modal">
    <div class="modal-content">
        <h4>A tener en cuenta:</h4>
        <ul class="collection">
            <li class="collection-item">
                Para asociar un talento a un proyecto, se debe buscar el talento en la tabla, después se debe presionar
                el botón con el ícono <i class="material-icons">done</i>,
                luego el talento se asociará al proyecto.
            </li>
            <li class="collection-item">
                Para seleccionar el talento líder del proyecto, debe presionar en la casilla "<b>Talento Líder</b>" del
                talento que será Talento líder del proyecto, esto se debe hacer luego de haber
                seleccionado los talentos que se asociarán al proyecto.
            </li>
            <li class="collection-item">
                Solo un talento asociado al proyecto puede ser <b>Talento Líder</b>.
            </li>
        </ul>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-primary btn-flat">Ok!</a>
    </div>
</div>

<div id="modalInformacioSobreLasIdeasDeProyecto_Proyecto" class="modal">
    <div class="modal-content">
        <h4>A tener en cuenta:</h4>
        <ul class="collection">
            <li class="collection-item">
                Para buscar una idea de proyecto y asociarla al registro del proyecto, debes seleccionar si la idea pasó
                o no por el CSIBT, acto seguido, seleccionar el botón con el ícono
                <i class="material-icons">search</i>.
            </li>
            <li class="collection-item">
                Para asociar una idea de proyecto debe presionar el botón con el ícono <i
                    class="material-icons">done</i> (esto, luego de listar las ideas de proyecto).
            </li>
            <li class="collection-item">
                En caso de que la idea de proyecto, no se haya inscrito como una idea y por tanto no haber pasado por
                taller de fortalecimiento y CSIBT, el/la Infocenter del nodo deberá registrarla desde su cuenta como
                una idea de proyecto con empresa o grupo de investigación según el caso.
            </li>
            <li class="collection-item">
                El nombre del proyecto se registrará por defecto con el nombre de la idea de proyecto, en caso de que se
                quiera cambiar, solo se debe editar el nombre del proyecto una vez se elige
                la idea de proyecto, el campo para cambiar el nombre del proyecto es: <b>Nombre de Proyecto</b>.
            </li>
        </ul>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-primary btn-flat">Ok!</a>
    </div>
</div>

<div id="modalInformacioDeLaEntidadesEnProyecto" class="modal">
    <div class="modal-content">
        <h4>A tener en cuenta:</h4>
        <ul class="collection">
            <li class="collection-item">
                Para asociar una entidad con la que se realizará el proyecto, primero se debe haber seleccionado una
                opcion del campo
                <b>Tipo de Articulación</b>, luego, puedes filtrar según el tipo de articulación seleccionado.
            </li>
            <li class="collection-item">
                En caso de no encontrar la entidad, puedes registrarla en el menú lateral izquierdo de la pantalla
                (Únicamente grupos de investigación y/o empresas).
            </li>
            <li class="collection-item">
                Solo se puede asociar <b>UNA ENTIDAD</b> a una proyecto.
            </li>
        </ul>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-primary btn-flat">Ok!</a>
    </div>
</div>

<div id="detallesEntregablesDeUnProyecto_modal" class="modal modal-fixed-footer">
    <div class="modal-content">
        <center>
            <h4 id="detallesEntregablesDeUnProyecto_titulo" class="center-aling"></h4>
        </center>
        <div class="divider"></div>
        <div id="detallesEntregablesDeUnProyecto_body"></div>
    </div>
    <div class="modal-footer  white-text">
        <a href="#!" class="modal-action modal-close waves-effect waves-primary btn-flat ">Cerrar</a>
    </div>
</div>

<div id="detallesDeUnProyecto_modal" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div id="detallesDeUnProyecto_titulo">

        </div>
        <div id="detallesDeUnProyecto_detalle"></div>
    </div>
    <div class="modal-footer  white-text">
        <a href="#!" class="modal-action modal-close waves-effect waves-primary btn-flat ">Cerrar</a>
    </div>
</div>

<div id="talentosAsociadosAUnProyecto_modal" class="modal">
    <div class="modal-content">
        <center>
            <h4 id="talentosAsociadosAUnProyecto_titulo" class="center-aling"></h4>
        </center>
        <div class="divider"></div>
        <div>
            <table class="striped">
                <thead class="bg-primary white-text">
                    <tr>
                        <th>Rol del Talento</th>
                        <th>Talento</th>
                        <th>Correo</th>
                        <th>Contacto</th>
                    </tr>
                </thead>
                <tbody id="talentosAsociadosAUnProyecto_table">

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer  white-text">
        <a href="#!" class="modal-action modal-close waves-effect waves-primary btn-flat">Cerrar</a>
    </div>
</div>

<div id="horasAsesoriasExpertosPorProyeto_modal" class="modal">
    <div class="modal-content">
        <center>
            <h4 id="horasAsesoriasExpertosPorProyeto_titulo" class="center-aling"></h4>
        </center>
        <div class="divider"></div>
        <div>
            <table class="striped">
                <thead class="bg-primary white-text">
                    <tr>
                        <th>Experto</th>
                        <th>Horas de asesoría directa</th>
                        <th>Horas de asesoría indirecta</th>
                    </tr>
                </thead>
                <tbody id="horasAsesoriasExpertosPorProyeto_table">

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer  white-text">
        <a href="#!" class="modal-action modal-close waves-effect waves-primary btn-flat">Cerrar</a>
    </div>
</div>
<div id="info_actividad_modal" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4 id="actividad_titulo" class="valign-wrapper truncate center-align "></h4>
        <div id="detalleActividad"></div>

    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-primary btn-flat ">Cerrar</a>
    </div>
</div>
