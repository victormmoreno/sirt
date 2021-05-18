@php
    $existe = isset($sede) ? true : false;
@endphp
<h5 class="center">Información de la sede</h5>
<div class="row">
    <div class="input-field col s12 m6 l6">
        @if ($existe)
            <input type="text" name="txtnombre_sede" id="txtnombre_sede" value="{{$sede->nombre_sede}}">
        @else
            <input type="text" name="txtnombre_sede" id="txtnombre_sede" value="">
        @endif
        <label for="txtnombre_sede">Nombre de la Sede <span class="red-text">*</span></label>
        <small id="txtnombre_sede-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
        @if ($existe)
        <input type="text" name="txtdireccion_sede" id="txtdireccion_sede" value="{{$sede->direccion}}">
        @else
        <input type="text" name="txtdireccion_sede" id="txtdireccion_sede" value="">
        @endif
        <label for="txtdireccion_sede">Dirección de la Sede</label>
        <small id="txtdireccion_sede-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
    <select class="js-states browser-default select2" id="txtdepartamento_sede" name="txtdepartamento_sede" onchange="getCiudadSede()" style="width: 100%" tabindex="-1">
        <option value="">Seleccione el departamento</option>
        @foreach($departamentos as $value)
            @if($existe)
                @if ($sede->ciudad->departamento->id == $value->id)
                <option value="{{$value->id}}" selected>{{$value->nombre}}</option> 
                @else
                <option value="{{$value->id}}">{{$value->nombre}}</option> 
                @endif
            @else
            <option value="{{$value->id}}">{{$value->nombre}}</option>
            @endif
        @endforeach
    </select>
    <label class="active" for="txtdepartamento_sede">Departamento de la Sede <span class="red-text">*</span></label>
    <small id="txtdepartamento_sede-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
    <select class="js-states browser-default select2" id="txtciudad_id_sede" name="txtciudad_id_sede" style="width: 100%" tabindex="-1">
        <option value="">Seleccione Primero el Departamento</option>
    </select>
    <label class="active" for="txtciudad_id_sede">Ciudad de la Sede <span class="red-text">*</span></label>
    <small id="txtciudad_id_sede-error" class="error red-text"></small>
    </div>
</div>