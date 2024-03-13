function isset(variable) {
    if (typeof variable != "undefined" && variable !== null) {
        return true;
    }
    return false;
}

function sendListNodos(url, input) {
    let nodosSend = input;
    return $.ajax({
        dataType: "json",
        type: "get",
        data: {
            nodos: nodosSend,
        },
        url: url,
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        },
    });
}

function consultarSeguimientoDeUnNodoFases(e, url) {
    e.preventDefault();
    input = $("#txtnodo_select_actual").val();
    if (!validarSelect(input)) {
        Swal.fire("Error!", "Debe seleccionar por lo menos un nodo", "warning");
        return false;
    } else {
        let ajax = sendListNodos(url, input);
        ajax.success(function (data) {
            graficoSeguimientoFases(data, graficosSeguimiento.nodo_fases);
        });
    }
}

function consultarSeguimientoEsperado(e, url) {
    e.preventDefault();
    input = $("#txtnodo_select_list").val();
    if (!validarSelect(input)) {
        Swal.fire("Error!", "Debe seleccionar por lo menos un nodo", "warning");
        return false;
    } else {
        let ajax = sendListNodos(url, input);
        ajax.success(function (data) {
            graficoSeguimientoEsperado(data, graficosSeguimiento.nodo_esperado);
        });
    }
}

function generarExcelConTodosLosIndicadores(e, nodo) {
    let idnodo = $("#txtnodo_id").val();
    let hoja = $("#txthoja_nombre").val();
    let fecha_inicio = $("#txtfecha_inicio_todos").val();
    let fecha_fin = $("#txtfecha_fin_todos").val();
    if (!isset(idnodo)) {
        idnodo = nodo;
    }
    if (!isset(hoja)) {
        hoja = "all";
    }

    if (fecha_inicio > fecha_fin) {
        Swal.fire("Error!", "Seleccione un rango de fechas válido", "error");
    } else {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: `${host_url}/excel/export_proyectos_indicadores`,
            xhrFields: {
                responseType: "blob",
            },
            data: {
                nodos: idnodo,
                hoja: hoja,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                type: "todos",
            },
            success: function (result, status, xhr) {
                let disposition = xhr.getResponseHeader("content-disposition");
                let matches = /"([^"]*)"/.exec(disposition);
                let filename =
                    matches != null && matches[1]
                        ? matches[1]
                        : "Proyecto_" +
                          hoja +
                          "_finalizados_" +
                          fecha_inicio +
                          "_" +
                          fecha_fin +
                          ".xlsx";

                let blob = new Blob([result], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;

                document.body.appendChild(link);

                link.click();
                document.body.removeChild(link);
            },
            error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + errorThrown);
            },
        });
    }
}

function generarExcelConTodosLosIndicadoresActuales(e, nodo) {
    let idnodo = $("#txtnodo_id_actuales").val();
    let hoja = $("#txthoja_nombre_actuales").val();
    if (!isset(idnodo)) {
        idnodo = nodo;
    }
    if (!isset(hoja)) {
        hoja = "all";
    }

    e.preventDefault();
    $.ajax({
        type: "get",
        url: `${host_url}/excel/export_proyectos_indicadores`,
        xhrFields: {
            responseType: "blob",
        },
        data: {
            nodos: idnodo,
            hoja: hoja,
            fecha_inicio: null,
            fecha_fin: null,
            type: "activos",
        },
        success: function (result, status, xhr) {
            let disposition = xhr.getResponseHeader("content-disposition");
            let matches = /"([^"]*)"/.exec(disposition);
            let filename =
                matches != null && matches[1]
                    ? matches[1]
                    : "Proyecto_" + hoja + "_activos_.xlsx";

            let blob = new Blob([result], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        },
    });
}

function generarExcelConTodosLosIndicadoresFinalizados(e, nodo) {
    let idnodo = $("#txtnodo_id_finalizados").val();
    let hoja = $("#txthoja_nombre_finalizados").val();
    let fecha_inicio = $("#txtfecha_inicio_cerrados").val();
    let fecha_fin = $("#txtfecha_fin_cerrados").val();
    if (!isset(idnodo)) {
        idnodo = nodo;
    }
    if (!isset(hoja)) {
        hoja = "all";
    }

    if (fecha_inicio > fecha_fin) {
        Swal.fire("Error!", "Seleccione un rango de fechas válido", "error");
    } else {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: `${host_url}/excel/export_proyectos_indicadores`,
            xhrFields: {
                responseType: "blob",
            },
            data: {
                nodos: idnodo,
                hoja: hoja,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                type: "finalizados",
            },
            success: function (result, status, xhr) {
                let disposition = xhr.getResponseHeader("content-disposition");
                let matches = /"([^"]*)"/.exec(disposition);
                let filename =
                    matches != null && matches[1]
                        ? matches[1]
                        : "Proyecto_" +
                          hoja +
                          "_finalizados_" +
                          fecha_inicio +
                          "_" +
                          fecha_fin +
                          ".xlsx";

                let blob = new Blob([result], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;

                document.body.appendChild(link);

                link.click();
                document.body.removeChild(link);
            },
            error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + errorThrown);
            },
        });
    }
}

function generarExcelConTodosLosIndicadoresInscritos(e, nodo) {
    let idnodo = $("#txtnodo_id_inscritos").val();
    let hoja = $("#txthoja_nombre_inscritos").val();
    let fecha_inicio = $("#txtfecha_inicio_inscritos").val();
    let fecha_fin = $("#txtfecha_fin_inscritos").val();
    if (!isset(idnodo)) {
        idnodo = nodo;
    }
    if (!isset(hoja)) {
        hoja = "all";
    }

    if (fecha_inicio > fecha_fin) {
        Swal.fire("Error!", "Seleccione un rango de fechas válido", "error");
    } else {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: `${host_url}/excel/export_proyectos_indicadores`,
            xhrFields: {
                responseType: "blob",
            },
            data: {
                nodos: idnodo,
                hoja: hoja,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                type: "inscritos",
            },
            success: function (result, status, xhr) {
                let disposition = xhr.getResponseHeader("content-disposition");
                let matches = /"([^"]*)"/.exec(disposition);
                let filename =
                    matches != null && matches[1]
                        ? matches[1]
                        : "Proyecto_" +
                          hoja +
                          "_inscritos_" +
                          fecha_inicio +
                          "_" +
                          fecha_fin +
                          ".xlsx";

                let blob = new Blob([result], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                let link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;

                document.body.appendChild(link);

                link.click();
                document.body.removeChild(link);
            },
            error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + errorThrown);
            },
        });
    }
}

function selectAll(source, elementaName) {
    checkboxes = document.getElementsByClassName(elementaName);
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
    }
}

function downloadMetas(e) {
    e.preventDefault();
    input = $("#txtnodo_metas_id").val();
    if (!validarSelect(input)) {
        Swal.fire("Error!", "Debe seleccionar por lo menos un nodo", "warning");
        return false;
    } else {
        document.frmDescargarMetas.submit();
    }
}

function downloadMetasArticulaciones(e) {
    e.preventDefault();
    input = $("#txtnodo_meta_articulaticion").val();
    if (!validarSelect(input)) {
        Swal.fire("Error!", "Debe seleccionar por lo menos un nodo", "warning");
        return false;
    } else {
        document.frmDescargarMetasArticulaciones.submit();
    }
}


function validarSelect(input) {
    if (input == null) {
        return false;
    }
    return true;
}

function verificarChecks(source, padre) {
    clase = source.classList[0];
    checkboxes = document.getElementsByClassName(clase);
    padre = document.getElementById(padre);
    state = false;
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        if (checkboxes[i].checked) {
            state = true;
            break;
        }
    }
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        if (!checkboxes[i].checked) {
            state = false;
            break;
        }
    }
    padre.checked = state;
}

function validarChecks(elementaName) {
    checkboxes = document.getElementsByClassName(elementaName);
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        if (checkboxes[i].checked == false) {
            return false;
        }
    }
    return true;
}

function downloadIdeasIndicadores(e) {
    e.preventDefault();
    input = $("#txtnodo_ideas_download").val();
    if (!validarSelect(input)) {
        Swal.fire("Error!", "Debe seleccionar por lo menos un nodo", "warning");
        return false;
    } else {
        document.frmDescargarIdeas.submit();
    }
}

//Articulations

function consultarSeguimientoArticulacionDeUnNodoFases(e, url) {
    e.preventDefault();
    input = $("#nodo_articulacion_actual").val();
    if (!validarSelect(input)) {
        Swal.fire("Error!", "Debe seleccionar por lo menos un nodo", "warning");
        return false;
    } else {
        let ajax = sendListNodos(url, input);
        ajax.success(function (data) {
            graficoSeguimientoArticulacionesFases(
                data,
                graficosArticulacionSeguimiento.nodo_fases
            );
        });
    }
}

function generarExcelConTodosLosIndicadoresArticulaciones() {
    let nodo = $("#txtnodo_articulacion_todos").val();
    let hoja = $("#txthoja_articulacion_todos").val();
    let fecha_inicio = $("#txtfecha_inicio_articulacion_todos").val();
    let fecha_fin = $("#txtfecha_fin_articulacion_todos").val();

    if (!isset(nodo)) {
        nodo = 0;
    }
    if (!isset(hoja)) {
        hoja = "all";
    }

    if (fecha_inicio > fecha_fin) {
        Swal.fire("Error!", "Seleccione fechas válidas", "error");
    } else {
        location.href = `/excel/export/${nodo}/articulaciones/${fecha_inicio}/${fecha_fin}/${hoja}`;
    }
}

function generarExcelIndicadoresArticulacionesInscritas() {
    let nodo = $("#txtnodo_articulaciones_inscritas").val();
    let hoja = $("#txthoja_articulaciones_inscritas").val();
    let fecha_inicio = $("#txtfecha_inicio_articulaciones_inscritas").val();
    let fecha_fin = $("#txtfecha_fin_articulaciones_inscritas").val();
    if (!isset(nodo)) {
        nodo = 0;
    }
    if (!isset(hoja)) {
        hoja = "all";
    }

    if (fecha_inicio > fecha_fin) {
        Swal.fire("Error!", "Seleccione un rango de fechas válido", "error");
    } else {
        location.href = `/excel/export_articulaciones_inscritos/${nodo}/${fecha_inicio}/${fecha_fin}/${hoja}`;
    }
}

function generarExcelIndicadoresArticulacionesActuales() {
    let node = $("#txtnodo_articulaciones_activas").val();
    let sheet = $("#txthoja_articulaciones_activas").val();
    if (!isset(node)) {
        node = 0;
    }
    if (!isset(sheet)) {
        sheet = "all";
    }
    location.href = `/excel/export_articulaciones_actuales/${node}/${sheet}`;
}

function generarExcelIndicadoresArticulacionesFinalizadas() {
    let nodo = $("#txtnodo_articulaciones_finalizadas").val();
    let hoja = $("#txthoja_articulaciones_finalizadas").val();
    let fecha_inicio = $("#txtfecha_inicio_finalizadas").val();
    let fecha_fin = $("#txtfecha_fin_finalizadas").val();

    if (!isset(nodo)) {
        nodo = 0;
    }
    if (!isset(hoja)) {
        hoja = "all";
    }
    if (fecha_inicio > fecha_fin) {
        Swal.fire("Error!", "Seleccione fechas válidas", "error");
    } else {
        location.href = `/excel/export_articulaciones_finalizadas/${nodo}/${fecha_inicio}/${fecha_fin}/${hoja}`;
    }
}
