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
                            <form action="{{route('csibt.store')}}" id="formComiteAgendamientoCreate" method="post">
                            @include('comite.infocenter.form_agendamiento', [
                                'btnText' => 'Guardar'
                            ])
                            {{-- <form>
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

                            </form> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection