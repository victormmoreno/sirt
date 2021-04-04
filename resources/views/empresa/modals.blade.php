<div id="detalleDeUnaEmpresaTecnoparque" class="modal">
    <div class="modal-content">
        <center><h4 id="modalDetalleDeUnaEmpresaTecnoparque_titulo" class="center-aling"></h4></center>
        <div class="divider"></div>
        <div id="modalDetalleDeUnaEmpresaTecnoparque_detalle_empresa"></div>
    </div>
    <div class="modal-footer white-text">
        <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat">Cerrar</a>
    </div>
</div>
<div id="contactosDeUnaEntidad_modal" class="modal">
  <form method="POST" action="" id="frmContactosEntidades">
    {!! csrf_field() !!}
    {!! method_field('PUT')!!}
    <div class="modal-content">
      <center>
        <h4 id="contactosDeUnaEntidad_titulo" class="center-aling">
        </h4>
        <a class="btn btn-floating modal-trigger" href="#modalReglasDeContactos">
          <i class="material-icons left">info_outline</i>
        </a>
      </center>
      <div class="divider"></div>
      <div>
        <table class="highlight">
          <tr>
            <th>Nombres del Contacto</th>
            <th>Correo del Contacto</th>
            <th>Teléfono del Contacto</th>
            <th>Nodo con contacto</th>
            <th>Eliminar</th>
          </tr>
          <tbody id="contactosDeUnaEntidad_table">

          </tbody>
        </table>
        <div class="row">
          <div class="col s6 offset-s6">
            <a class="btn" onclick="addNuevoContacto();"><i class="material-icons left">add</i>Añadir</a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer  white-text">
      <a href="#!" class="btn modal-action modal-close waves-effect waves-yellow btn-flat"><i class="material-icons left">close</i>Cerrar</a>
      <button type="submit" class="btn green" name="button"><i class="material-icons left">done</i>Guardar Cambios</button>
    </div>
  </form>
</div>
<div id="modalReglasDeContactos" class="modal">
  <div class="modal-content">
    <h4>Debes tener en cuenta que a la hora de registrar un contacto con una empresa/grupo de investigación:</h4>
    <ul class="collection">
      <li class="collection-item">Los nombres de los contactos deben tener entre 10 y 60 carácteres (Los espacios tambien cuentan como caracter), además
        que este campo no admite carácteres especiales como @$%_!...</li>
      <li class="collection-item">Los correos de los contacto deben tener entre 7 y 100 carácteres.</li>
      <li class="collection-item">Los teléfonos de los contactos deben tener entre 7 y 11 carácteres, estos deben ser <b>NUMÉRICOS</b>.</li>
      <li class="collection-item"><b>Todos los campos son obligatorios.</b></li>
    </ul>
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok!</a>
  </div>
</div>
