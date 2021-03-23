<div class="row">
    <div class="input-field col s12 m6 l6">
      <input type="text" name="txtnit_empresa" id="txtnit_empresa" value="" {{$vista == 'ideas' ? 'readonly' : ''}}>
      <label for="txtnit_empresa">Nit de la Empresa (Sin puntos ni dígito de verificación) <span class="red-text">*</span></label>
      <small id="txtnit_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
      <input type="text" name="txtcodigo_ciiu_empresa" id="txtcodigo_ciiu_empresa" value="">
      <label for="txtcodigo_ciiu_empresa">Código CIIU de la Empresa</label>
      <small id="txtcodigo_ciiu_empresa-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m4 l4">
        <input type="text" name="txtnombre_empresa" id="txtnombre_empresa" value="">
        <label for="txtnombre_empresa">Nombre de la Empresa <span class="red-text">*</span></label>
        <small id="txtnombre_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m4 l4">
        <input type="text" name="txtfecha_creacion_empresa" id="txtfecha_creacion_empresa" value="" class="datepicker picker__input">
        <label for="txtfecha_creacion_empresa">Fecha de creación de la empresa</label>
        <small id="txtfecha_creacion_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m4 l4">
        <select class="" id="txtsector_empresa" name="txtsector_empresa" style="width: 100%" tabindex="-1">
        <option value="">Seleccione el sector</option>
        @foreach($sectores as $value)
            <option value="{{$value->id}}">{{$value->nombre}}</option>
        @endforeach
        </select>
        <label for="txtsector_empresa">Sector de la Empresa <span class="red-text">*</span></label>
        <small id="txtsector_empresa-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input type="text" name="txtemail_entidad" id="txtemail_entidad" value="">
        <label for="txtemail_entidad">Email de la Empresa</label>
        <small id="txtemail_entidad-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
        <input type="text" name="txtdireccion_empresa" id="txtdireccion_empresa" value="">
        <label for="txtdireccion_empresa">Dirección de la Empresa</label>
        <small id="txtdireccion_empresa-error" class="error red-text"></small>
        </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
    <select class="js-states browser-default select2" id="txtdepartamento_empresa" name="txtdepartamento_empresa" onchange="EmpresaCreate.getCiudad()" style="width: 100%" tabindex="-1">
        <option value="">Seleccione el departamento</option>
        @foreach($departamentos as $value)
        <option value="{{$value->id}}">{{$value->nombre}}</option>
        @endforeach
    </select>
    <label class="active" for="txtdepartamento_empresa">Departamento de la Empresa <span class="red-text">*</span></label>
    <small id="txtdepartamento_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
    <select class="js-states browser-default select2" id="txtciudad_id_empresa" name="txtciudad_id_empresa" style="width: 100%" tabindex="-1">
        <option value="">Seleccione Primero el Departamento</option>
    </select>
    <label class="active" for="txtciudad_id_empresa">Ciudad de la Empresa <span class="red-text">*</span></label>
    <small id="txtciudad_id_empresa-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
    <select class="" id="txttamanhoempresa_id_empresa" name="txttamanhoempresa_id_empresa" style="width: 100%" tabindex="-1">
        <option value="">Seleccione el tamaño de la empresa</option>
        @foreach($tamanhos as $value)
        <option value="{{$value->id}}">{{$value->nombre}}</option>
        @endforeach
    </select>
    <label for="txttamanhoempresa_id_empresa">Tamaño de la Empresa <span class="red-text">*</span></label>
    <small id="txttamanhoempresa_id_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
    <select class="" id="txttipoempresa_id_empresa" name="txttipoempresa_id_empresa" style="width: 100%" tabindex="-1">
        <option value="">Seleccione el tipo de la empresa</option>
        @foreach($tipos as $value)
        <option value="{{$value->id}}">{{$value->nombre}}</option>
        @endforeach
    </select>
    <label for="txttipoempresa_id_empresa">Tipo de Empresa <span class="red-text">*</span></label>
    <small id="txttipoempresa_id_empresa-error" class="error red-text"></small>
    </div>
</div>
