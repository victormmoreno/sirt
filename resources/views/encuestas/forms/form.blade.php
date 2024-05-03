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
<div id="formularioEncuestas">
    {{-- <div id="seccion">
        <div class="row card-panel">
            <div class="row">
                <h4>Seccion <a class="btn btn-flat right bg-danger white-text"><i class="material-icons left">delete_sweep</i>Borrar sección</a></h4>
                <p>Descripción</p>
            </div>
            <div id="preguntasSeccion">
    
            </div>
            <div class="input-field col s12 m4 l4">
                <select>
                    <option value="" disabled selected>Nueva pregunta</option>
                    <option value="radio">Selección única</option>
                    <option value="checkbox">Selección múltiple</option>
                    <option value="text">Texto</option>
                    <option value="likert">Likert</option>
                </select>
                <label><i class="material-icons arrow-l left">add</i>Insertar pregunta</label>
            </div>
        </div>
    </div> --}}
</div>
<div class="row">
    <div class="col s12 m12 l12">
        <a onclick="nuevaSeccion()" class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button left show-on-large hide-on-med-and-down">
            <i class="material-icons left">add</i>
            Agregar nueva sección
        </a>
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

@push('script')
    <script>
   

    </script>
@endpush