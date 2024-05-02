{!! csrf_field() !!}
@php
    $existe = isset($encuesta) ? true : false;
@endphp
<div class="row">
    <div class="input-field col s12 m12 l12">
        @if ($existe)
            <input type="text" id="txtTitulo" name="txtTitulo" value="{{ $encuesta->titulo }}" required>
        @else
            <input type="text" id="txtTitulo" name="txtTitulo" value="" required>
        @endif
        <label for="txtTitulo">Nombre de la encuesta <span class="red-text">*</span></label>
        <small id="txtTitulo-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        @if ($existe)
            <input type="text" id="txtDescripcion" name="txtDescripcion" value="{{ $encuesta->descripcion }}">
        @else
            <input type="text" id="txtDescripcion" name="txtDescripcion" value="">
        @endif
        <label for="txtDescripcion">Descripción (Opcional)</label>
        <small id="txtDescription-error" class="error red-text"></small>
    </div>
</div>
<center>
    <button type="submit" class="waves-effect waves-light btn bg-secondary center-align">
        <i class="material-icons right">send</i>
        Guardar
    </button>
    <a href="{{ $existe ? route('encuesta.index') : route('encuesta.index') }}" class="waves-effect bg-danger btn center-align">
        <i class="material-icons left">backspace</i>Cancelar
    </a>
</center>