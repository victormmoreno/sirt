@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('csibt')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Comité de Selección de Ideas
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('csibt')}}">CSIBT</a></li>
                            <li class="active">Nuevo CSIBT</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <br>
                        <center>
                            <span class="card-title center-align">Nuevo Comité de Selección de Ideas - Tecnoparque nodo
                                {{ \NodoHelper::returnNodoUsuario() }}</span>
                        </center>
                        <div class="divider"></div>
                        <div class="row">
                            <form action="{{route('csibt.store')}}" id="formComiteCreate" method="post"
                                onsubmit="return checkSubmit()">
                                {!! csrf_field() !!}
                                @if($errors->any())
                                <div class="card red lighten-3">
                                    <div class="row">
                                        <div class="col s12 m12">
                                            <div class="card-content white-text">
                                                <p><i class="material-icons left"> info_outline</i> Los datos marcados
                                                    con * son obligatorios</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <center>
                                    <span class="card-title center-align">Datos del Comité</span> <i
                                        class="Small material-icons prefix">account_circle </i>
                                </center>
                                <div class="divider"></div>
                                <div class="row">
                                    <div class="input-field col s12 m6 l6">
                                        <i class="material-icons prefix">location_city</i>
                                        <input id="txtnombrenodo" type="text"
                                            value="{{ \NodoHelper::returnNameNodoUsuario() }}" name="txtnombrenodo"
                                            disabled>
                                        <label for="txtnombrenodo">Nodo <span class="red-text">*</span></label>
                                    </div>
                                    <div class="input-field col s12 m6 l6">
                                        <i class="material-icons prefix">date_range</i>
                                        <input id="txtfechacomite_create" type="text" name="txtfechacomite_create"
                                            value="{{old('txtfechacomite_create', Carbon\Carbon::now()->toDateString()) }}">
                                        <label for="txtfechacomite_create" class="active">Fecha del Comité <span
                                                class="red-text">*</span></label>
                                        @error('txtfechacomite_create')
                                        <label id="txtfechacomite_create-error" class="error"
                                            for="txtfechacomite_create">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <center>
                                    <span class="card-title center-align">Ideas de Proyecto</span>
                                    <i class="Small material-icons prefix">info</i>
                                </center>
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="card-content">
                                            <h5>
                                                <span class="red-text text-darken-2">Para registrar las ideas en el
                                                    comité dar click en el botón <a
                                                        class="btn-floating waves-effect waves-light red"><i
                                                            class="material-icons">add</i></a></span>
                                            </h5>
                                            <p>Si desea agregar mas ideas de proyecto por favor seleccione..</p>
                                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                                <li>
                                                    <div class="collapsible-header active blue-grey lighten-1"><i
                                                            class="material-icons">lightbulb</i>Seleccione las ideas de
                                                        proyecto que se presentarán en el comité</div>
                                                    <div class="collapsible-body">
                                                        <div class="card-content">
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6">
                                                                    <select id="txtideaproyecto"
                                                                        class="js-states browser-default select2"
                                                                        style="width: 100%;" name="txtideaproyecto">
                                                                        <option value="0">Seleccione las ideas de
                                                                            proyecto que se presentarán en el comité
                                                                        </option>
                                                                        @foreach ($ideas as $key => $value)
                                                                        <option value="{{$value['id']}}">
                                                                            {{$value['nombre_idea']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="#txtideaproyecto" class="active">Ideas
                                                                        de Proyecto <span
                                                                            class="red-text">*</span></label>
                                                                </div>
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">access_time</i>
                                                                    <input id="txthoraidea" type="text"
                                                                        class="pickertime" name="txthoraidea">
                                                                    {{-- <span class="helper-text">Hora</span> --}}
                                                                    <label for="txthoraidea">Hora <span
                                                                            class="red-text">*</span></label>
                                                                    {{-- <small>Hora <span class="red-text">*</span></small> --}}
                                                                </div>
                                                            </div>
                                                            <center>
                                                                <a onclick="addIdeaComite()"
                                                                    class="indigo lighten-2 btn-large"
                                                                    data-position="bottom" data-delay="50"
                                                                    data-tooltip="Agregar la idea de proyecto seleccionada al comité"><i
                                                                        class="material-icons left">add</i>Agregar</a>
                                                            </center>
                                                            <div class="card-content">
                                                                <table class="responsive-table" style="width: 100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 30%">Idea de Proyecto</th>
                                                                            <th style="width: 10%">Hora</th>
                                                                            <th style="width: 10%">Eliminar</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tblIdeasComiteCreate">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="row">
                                    <center>
                                        <button type="submit" class="btn waves-effect cyan darken-1 center-aling"><i
                                                class="material-icons right">done_all</i>Registrar</button>
                                        <a href="{{route('csibt')}}"
                                            class="btn waves-effect red lighten-2  center-aling"><i
                                                class="material-icons right">backspace</i>Cancelar</a>
                                    </center>
                                </div>
                                <!-- <a id="btnSave" class="btn" readonly><i class="material-icons right">done_all</i>Registrar</a> -->
                            </form>
                            <form>
                                <center>
                                    <span class="card-title center-align">Datos del Comité</span> <i
                                        class="Small material-icons prefix">account_circle </i>
                                </center>
                                <div class="divider"></div>
                                <div class="row">
                                    <div class="input-field col s12 m6 l6">
                                        <i class="material-icons prefix">location_city</i>
                                        <input id="txtnombrenodo" type="text"
                                            value="{{ \NodoHelper::returnNameNodoUsuario() }}" name="txtnombrenodo"
                                            disabled>
                                        <label for="txtnombrenodo">Nodo <span class="red-text">*</span></label>
                                    </div>
                                    <div class="input-field col s12 m6 l6">
                                        <i class="material-icons prefix">date_range</i>
                                        <input id="txtfechacomite_create" type="text" name="txtfechacomite_create"
                                            value="{{old('txtfechacomite_create', Carbon\Carbon::now()->toDateString()) }}">
                                        <label for="txtfechacomite_create" class="active">Fecha del Comité <span
                                                class="red-text">*</span></label>
                                        @error('txtfechacomite_create')
                                        <label id="txtfechacomite_create-error" class="error"
                                            for="txtfechacomite_create">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <center>
                                    <span class="card-title center-align">Ideas de Proyecto</span>
                                    <i class="Small material-icons prefix">info</i>
                                </center>
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="card-content">
                                            <div class="row">
                                                <div class="col s12 m4 l4">
                                                    <a href="">
                                                        <div class="card-panel green lighten-3 black-text center">
                                                            Enviar citación.
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                                <li>
                                                    <div class="collapsible-header active blue-grey lighten-1"><i
                                                            class="material-icons">lightbulb</i>Seleccione las ideas de
                                                        proyecto que se presentarán en el comité</div>
                                                    <div class="collapsible-body">
                                                        <div class="card-content">
                                                            <div class="card-content">
                                                                <table class="responsive-table" style="width: 100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 30%">Idea de Proyecto</th>
                                                                            <th style="width: 10%">Hora</th>
                                                                            <th style="width: 10%">¿Admitido?</th>
                                                                            <th style="width: 50%">Observaciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="">
                                                                        <tr>
                                                                            <td>Idea citada #1</td>
                                                                            <td>Hora de la dea citada #1</td>
                                                                            <td>
                                                                                <p class="p-v-xs">
                                                                                    <input type="checkbox"
                                                                                        id="txtcronograma"
                                                                                        name="txtcronograma" value="1">
                                                                                    <label
                                                                                        for="txtcronograma">¿Admitido?.</label>
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <i
                                                                                    class="material-icons prefix">speaker_notes</i>
                                                                                <textarea name="txtobservacionescomite"
                                                                                    class="materialize-textarea"
                                                                                    length="1000" maxlength="1000"
                                                                                    id="txtobservacionescomite">{{ old('txtobservacionescomite') }}</textarea>
                                                                                <label
                                                                                    for="txtobservacionescomite">Observaciones
                                                                                    de la Idea</label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Idea citada #2</td>
                                                                            <td>Hora de la dea citada #2</td>
                                                                            <td>
                                                                                <p class="p-v-xs">
                                                                                    <input type="checkbox"
                                                                                        id="txtcronograma"
                                                                                        name="txtcronograma" value="1">
                                                                                    <label
                                                                                        for="txtcronograma">¿Admitido?.</label>
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <i
                                                                                    class="material-icons prefix">speaker_notes</i>
                                                                                <textarea name="txtobservacionescomite"
                                                                                    class="materialize-textarea"
                                                                                    length="1000" maxlength="1000"
                                                                                    id="txtobservacionescomite">{{ old('txtobservacionescomite') }}</textarea>
                                                                                <label
                                                                                    for="txtobservacionescomite">Observaciones
                                                                                    de la Idea</label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Idea citada #3</td>
                                                                            <td>Hora de la dea citada #3</td>
                                                                            <td>
                                                                                <p class="p-v-xs">
                                                                                    <input type="checkbox"
                                                                                        id="txtcronograma"
                                                                                        name="txtcronograma" value="1">
                                                                                    <label
                                                                                        for="txtcronograma">¿Admitido?.</label>
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <i
                                                                                    class="material-icons prefix">speaker_notes</i>
                                                                                <textarea name="txtobservacionescomite"
                                                                                    class="materialize-textarea"
                                                                                    length="1000" maxlength="1000"
                                                                                    id="txtobservacionescomite">{{ old('txtobservacionescomite') }}</textarea>
                                                                                <label
                                                                                    for="txtobservacionescomite">Observaciones
                                                                                    de la Idea</label>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="row">
                                    <center>
                                        <button type="submit" class="btn waves-effect cyan darken-1 center-aling"><i
                                                class="material-icons right">done_all</i>Registrar</button>
                                        <a href="{{route('csibt')}}"
                                            class="btn waves-effect red lighten-2  center-aling"><i
                                                class="material-icons right">backspace</i>Cancelar</a>
                                    </center>
                                </div>
                                <!-- <a id="btnSave" class="btn" readonly><i class="material-icons right">done_all</i>Registrar</a> -->

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('script')
<script>
    function addIdeaComite() {
        let id = $('#txtideaproyecto').val();
        let hora = $('#txthoraidea').val();
    if (noRepeat(id) == false) {
        ideaYaSeEncuentraAsociado();
    } else {
        pintarIdeaEnLaTabla(id, hora);
    }
}

function pintarIdeaEnLaTabla(id, hora) {
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/idea/detallesIdea/' + id
    }).done(function (ajax) {

        let fila = prepararFilaEnLaTablaDeIdeas(ajax, hora);
        $('#tblIdeasComiteCreate').append(fila);
        // talentoSeAsocioAlProyecto();
    });
}

function prepararFilaEnLaTablaDeIdeas(ajax, hora) { // El ajax.talento.id es el id del TALENTO, no del usuario
    let idIdea = ajax.detalles.id;
    let fila = '<tr class="selected" id=ideaAsociadad' + idIdea + '>' + '<td><input type="hidden" name="ideas[]" value="' + idIdea + '">' + ajax.detalles.nombre_proyecto + '</td><td>'+hora+'</td>' + '<td><a class="waves-effect red lighten-3 btn" onclick="method(' + idIdea + ');"><i class="material-icons">delete_sweep</i></a></td>' + '</tr>';
    return fila;
}

function ideaYaSeEncuentraAsociado() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'warning',
        title: 'El talento ya se encuentra asociado al proyecto!'
    });
}


function noRepeat(id) {
    let idIdea = id;
    let retorno = true;
    let a = document.getElementsByName("ideas[]");
    for (x = 0; x < a.length; x ++) {
        if (a[x].value == idIdea) {
            retorno = false;
            break;
        }
    }
    return retorno;
}
</script>
@endpush