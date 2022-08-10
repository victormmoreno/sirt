function selectAll(source, elementaName) {
    checkboxes = document.getElementsByClassName(elementaName);
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }

  function downloadMetas(e) {
    e.preventDefault();
    if (!validarChecks("metas_down")) {
        Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
        return false;
    } else {
        document.frmDescargarMetas.submit();
    }
  }

  function verificarChecks(source, padre) {
    clase = source.classList[0];
    checkboxes = document.getElementsByClassName(clase);
    padre = document.getElementById(padre);
    state = true;
    for(var i=0, n=checkboxes.length;i<n;i++) {
      if (checkboxes[i].checked != source.checked) {
        state = false;
        break;
      }
    }
    padre.checked = state;
  }

  function validarChecks(elementaName) {
    checkboxes = document.getElementsByClassName(elementaName);
    for(var i=0, n=checkboxes.length;i<n;i++) {
        if (checkboxes[i].checked == false) {
          return false;
        }
      }
      return true;
  }

  function downloadIdeasIndicadores(e) {
    e.preventDefault();
    if (!validarChecks("ideas_download")) {
        Swal.fire('Error!', 'Debe seleccionar por lo menos un nodo', 'warning');
        return false;
    } else {
        document.frmDescargarIdeas.submit();
    }
  }