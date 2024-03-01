{!! csrf_field() !!}
@php
    $existe = isset($tag) ? true : false;
@endphp
<div class="row">
    <div class="input-field col s12 m6 l6">
        @if ($existe)
        <select style="width: 100%" class="js-states" id="selectType" name="selectType" required>
            <option value="">Seleccione el tipo de caracterización</option>
            @forelse ($types as $id => $type)
            <option value="{{$type}}" {{ $type == $id ? 'selected' : '' }}>{{class_basename($type)}}</option>
            @empty
            <option value="">No hay información disponible</option>
            @endforelse
        </select>
        @else
        <select style="width: 100%" class="js-states" id="selectType" name="selectType" required>
            <option value="">Seleccione el tipo de caracterización</option>
            @forelse ($types as $id => $type)
            <option value="{{$type}}">{{class_basename($type)}}</option>
            @empty
            <option value=""> No hay información disponible</option>
            @endforelse
        </select>
        @endif
        <label for="selectType">Tipos de caracterización <span class="red-text">*</span></label>
        <small id="selectType-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
        @if ($existe)
            <input type="text" id="txtTag" name="txtTag" value="{{ $tag->name }}" required>
        @else
            <input type="text" id="txtTag" name="txtTag" value="" required>
        @endif
        <label for="txtTag">Nombre de caracterización <span class="red-text">*</span></label>
        <small id="txtTag-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        @if ($existe)
            <input type="text" id="txtDescription" name="txtDescription" value="{{ $tag->description }}">
        @else
            <input type="text" id="txtDescription" name="txtDescription" value="">
        @endif
        <label for="txtTag">Descripción (Opcional)</label>
        <small id="txtDescription-error" class="error red-text"></small>
    </div>
</div>
<center>
    <button type="submit" class="waves-effect waves-light btn bg-secondary center-align">
        <i class="material-icons right">send</i>
        Guardar
    </button>
    <a href="{{ $existe ? route('home') : route('home') }}" class="waves-effect bg-danger btn center-align">
        <i class="material-icons left">backspace</i>Cancelar
    </a>
</center>