@php
    $existe = isset($empresa) ? true : false;
@endphp
<div class="row">
    <div class="input-field col s12 m6 l6">
        @if ($existe)
            <input type="text" name="txtnit_empresa" id="txtnit_empresa" value="{{$empresa->nit}}" {{$vista == 'ideas' ? 'readonly' : ''}}>
        @else
            <input type="text" name="txtnit_empresa" id="txtnit_empresa" value="" {{$vista == 'ideas' ? 'readonly' : ''}}>
        @endif
      <label for="txtnit_empresa">Nit de la Empresa (Sin puntos) <span class="red-text">*</span></label>
      <small id="txtnit_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s11 m5 l5">
        @if ($existe)
        <input type="text" name="txtcodigo_ciiu_empresa" id="txtcodigo_ciiu_empresa" value="{{$empresa->codigo_ciiu}}">
        @else
        <input type="text" name="txtcodigo_ciiu_empresa" id="txtcodigo_ciiu_empresa" value="">
        @endif
      <label for="txtcodigo_ciiu_empresa">Código CIIU de la actividad de la empresa <span class="red-text">*</span></label>
      <small id="txtcodigo_ciiu_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s1 m1 l1">
      <a href="https://www.ccb.org.co/Inscripciones-y-renovaciones/Todo-sobre-el-Codigo-CIIU" target="_blank"><i class="material-icons left">help</i></a>
    </div>
  </div>
  <div class="row">
    <div class="input-field col s12 m4 l4">
        @if ($existe)
        <input type="text" name="txtnombre_empresa" id="txtnombre_empresa" value="{{$empresa->nombre}}">
        @else
        <input type="text" name="txtnombre_empresa" id="txtnombre_empresa" value="">
        @endif
        <label for="txtnombre_empresa">Nombre de la Empresa <span class="red-text">*</span></label>
        <small id="txtnombre_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m4 l4">
        @if ($existe)
        <input type="text" name="txtfecha_creacion_empresa" id="txtfecha_creacion_empresa" value="{{$empresa->fecha_creacion}}" class="datepicker picker__input">
        @else
        <input type="text" name="txtfecha_creacion_empresa" id="txtfecha_creacion_empresa" value="" class="datepicker picker__input">
        @endif
        <label for="txtfecha_creacion_empresa">Fecha de creación de la empresa</label>
        <small id="txtfecha_creacion_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m4 l4">
        <select class="" id="txtsector_empresa" name="txtsector_empresa" style="width: 100%" tabindex="-1">
        <option value="">Seleccione el sector</option>
        @foreach($sectores as $value)
            @if($existe)
                @if ($empresa->sector_id == $value->id)
                <option value="{{$value->id}}" selected>{{$value->nombre}}</option> 
                @else
                <option value="{{$value->id}}">{{$value->nombre}}</option> 
                @endif
            @else
            <option value="{{$value->id}}">{{$value->nombre}}</option> 
            @endif
        @endforeach
        </select>
        <label for="txtsector_empresa">Sector de la Empresa <span class="red-text">*</span></label>
        <small id="txtsector_empresa-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        @if ($existe)
        <input type="text" name="txtemail_empresa" id="txtemail_empresa" value="{{$empresa->email}}">
        @else
        <input type="text" name="txtemail_empresa" id="txtemail_empresa" value="">
        @endif
        <label for="txtemail_empresa">Email de la Empresa</label>
        <small id="txtemail_empresa-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
    <select class="" id="txttamanhoempresa_id_empresa" name="txttamanhoempresa_id_empresa" style="width: 100%" tabindex="-1">
        <option value="">Seleccione el tamaño de la empresa</option>
        @foreach($tamanhos as $value)
            @if($existe)
                @if ($empresa->tamanhoempresa_id == $value->id)
                <option value="{{$value->id}}" selected>{{$value->nombre}}</option> 
                @else
                <option value="{{$value->id}}">{{$value->nombre}}</option> 
                @endif
            @else
            <option value="{{$value->id}}">{{$value->nombre}}</option> 
            @endif
        @endforeach
    </select>
    <label for="txttamanhoempresa_id_empresa">Tamaño de la Empresa <span class="red-text">*</span></label>
    <small id="txttamanhoempresa_id_empresa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
    <select class="" id="txttipoempresa_id_empresa" name="txttipoempresa_id_empresa" style="width: 100%" tabindex="-1">
        <option value="">Seleccione el tipo de la empresa</option>
        @foreach($tipos as $value)
            @if($existe)
                @if ($empresa->tipoempresa_id == $value->id)
                <option value="{{$value->id}}" selected>{{$value->nombre}}</option> 
                @else
                <option value="{{$value->id}}">{{$value->nombre}}</option> 
                @endif
            @else
            <option value="{{$value->id}}">{{$value->nombre}}</option>
            @endif
        @endforeach
    </select>
    <label for="txttipoempresa_id_empresa">Tipo de Empresa <span class="red-text">*</span></label>
    <small id="txttipoempresa_id_empresa-error" class="error red-text"></small>
    </div>
</div>