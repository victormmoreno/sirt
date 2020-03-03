{!! csrf_field() !!}
@php
$existe = isset($articulacion) ? true : false;
@endphp
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input disabled id="txtgestor" name="txtgestor"
            value="{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}" type="text">
        <label for="txtgestor" class="">Gestor</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input disabled id="txtlinea" name="txtlinea" value="{{ auth()->user()->gestor->lineatecnologica->nombre }}"
            type="text">
        <label for="txtlinea" class="">Línea Tecnológica</label>
    </div>
</div>
<div class="row">
    <div class="col s12 m12 l12">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">Debes tener en cuenta que solo se puede realizar un articulación con un solo
                    grupo de investigación.</li>
            </ul>
        </blockquote>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="card-panel grey lighten-3 col s12 m6 l6">
        <div class="row">
            <div class="input-field col s12 m12 l12">
                <input type="hidden" name="txtgrupo_id" id="txtgrupo_id" value="">
                <input type="text" id="txtgrupoInvestigacion" name="txtgrupoInvestigacion"
                    value="{{ $btnText == 'Guardar' ? '' : '' }}" readonly>
                <label for="txtgrupoInvestigacion">Grupo de Investigación</label>
                <small id="txtgrupo_id-error" class="error red-text"></small>
            </div>
            <center>
                <a class="btn-floating blue" onclick="consultarGruposInvestigacion_FaseInicio_Articulaciones();">
                    <i class="material-icons left">search</i>Buscar
                </a>
            </center>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <div class="input-field col s12 m12 l12">
            <label for="txtnombre">Nombre de la Articulación <span class="red-text">*</span></label>
            <input type="text" id="txtnombre" name="txtnombre" />
            <small id="txtnombre-error" class="error red-text"></small>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <h5 class="center"><i class="material-icons">supervised_user_circle</i>Talentos que participarán en el proyecto</h5>
</div>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-content">
            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header active blue-grey lighten-1"><i class="material-icons">people</i>
                        Pulse aquí para ver la información de los talentos.
                    </div>
                    <div class="collapsible-body">
                        <div class="card-content">
                            @if ($existe)
                            @if ($articulacion->fase->nombre == 'Inicio')
                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header cyan lighten-1"><i
                                            class="material-icons">group_add</i>
                                        Pulse aquí para ver los talentos y asociarlos a la articulación.</div>
                                    <div class="collapsible-body">
                                        {{-- Collapsible 1 --}}
                                        <div class="card-content">
                                            <div class="row">
                                                <table id="talentosDeTecnoparque_Articulacion_FaseInicio_table"
                                                    style="width: 100%">
                                                    <thead>
                                                        <th>Documento de Identidad</th>
                                                        <th>Nombres del Talento</th>
                                                        <th>Asociar al Proyecto</th>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            @endif
                            @else
                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header cyan lighten-1"><i
                                            class="material-icons">group_add</i>
                                        Pulse aquí para ver los talentos y asociarlos a la articulación.</div>
                                    <div class="collapsible-body">
                                        {{-- Collapsible 1 --}}
                                        <div class="card-content">
                                            <div class="row">
                                                <table id="talentosDeTecnoparque_Articulacion_FaseInicio_table"
                                                    style="width: 100%">
                                                    <thead>
                                                        <th>Documento de Identidad</th>
                                                        <th>Nombres del Talento</th>
                                                        <th>Asociar al Proyecto</th>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            @endif
                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header active green lighten-1"><i
                                            class="material-icons">how_to_reg</i>
                                        Pulse aquí para la información de los talentos asociados a la articulación.
                                    </div>
                                    <div class="collapsible-body">
                                        {{-- Collapsible 2 --}}
                                        <div class="card-content">
                                            <div class="row">
                                                <table id="detalleTalentosDeUnaArticulacion_Create" class="striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 15%">Talento Interlocutor</th>
                                                            <th style="width: 40%">Talento</th>
                                                            @if ($existe)
                                                            @if ($articulacion->fase->nombre == 'Inicio')
                                                            <th style="width: 20%">Eliminar</th>
                                                            @endif
                                                            @else
                                                            <th style="width: 20%">Eliminar</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($existe)
                                                        @foreach ($articulacion->articulacion_proyecto->talentos as $key
                                                        => $value)
                                                        <tr id="talentoAsociadoALaArticulacion{{$value->id}}">
                                                            <td>
                                                                <input type="radio" {{$articulacion->fase->nombre != 'Inicio' ? 'disabled' : '' }} class="with-gap" {{$value->pivot->talento_lider == 1 ? 'checked' : ''}} name="radioTalentoLider" id="radioButton'{{$value->id}}'" value="{{$value->id}}" />
                                                                <label for="radioButton'{{$value->id}}'"></label>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="talentos[]" value="{{$value->id}}">{{$value->user()->withTrashed()->first()->documento}} - {{$value->user()->withTrashed()->first()->nombres}} {{$value->user()->withTrashed()->first()->apellidos}}
                                                            </td>
                                                            @if ($articulacion->fase->nombre == 'Inicio')
                                                            <td>
                                                                <a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeProyecto_FaseInicio({{$value->id}});"><i class="material-icons">delete_sweep</i></a>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="talentos-error" class="error red-text"></div>
                                            <div id="radioTalentoLider-error" class="error red-text"></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <h5 class="center">
        Productos a alcanzar.
    </h5>
</div>
<div class="row">
    <ul class="collection">
    @foreach ($productos as $item => $value)
    <div class="col s12 m4 l4">
            <li class="collection-item">
                @if(isset($articulacion))
                <p class="p-v-xs">
                    <input type="checkbox" name="productos[]" class="filled-in" id="producto-{{$value->id}}">
                    <label for="producto-{{$value->id}}">{{$value->nombre}}</label>
                </p>
                @else
                <p class="p-v-xs">
                    <input type="checkbox" name="productos[]" class="filled-in" id="producto-{{$value->id}}">
                    <label for="producto-{{$value->id}}">{{$value->nombre}}</label>
                </p>
                @endif
            </li>
        </div>    
        @endforeach
    </ul>
</div>
<div class="divider"></div>
<div class="row">
    <h5 class="center">Acuerdos de coautoría y alcance de la articulación.</h5>
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <textarea {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} name="txtacuerdos" class="materialize-textarea" length="1000" maxlength="1000" id="txtacuerdos">{{ $btnText == 'Guardar' ? '' : $proyecto->articulacion_proyecto->actividad->objetivo_general }}</textarea>
            @else
            <textarea name="txtacuerdos" class="materialize-textarea" length="1000" maxlength="1000" id="txtacuerdos"></textarea>
            @endif
            <label for="txtacuerdos">Acuerdos de coautoría <span class="red-text">*</span></label>
            <small id="txtacuerdos-error" class="error red-text"></small>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <textarea {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} name="txtalcance_articulacion" class="materialize-textarea" length="1000" maxlength="1000" id="txtalcance_articulacion">{{ $btnText == 'Guardar' ? '' : $proyecto->alcance_proyecto }}</textarea>
            @else
            <textarea name="txtalcance_articulacion" class="materialize-textarea" length="1000" maxlength="1000" id="txtalcance_articulacion"></textarea>
            @endif
            <label for="txtalcance_articulacion">Alcance de la articulación <span class="red-text">*</span></label>
            <small id="txtalcance_articulacion-error" class="error red-text"></small>
        </div>
    </div>
</div>
<div class="divider"></div>
<center>
    @if ($existe)
        @if ($articulacion->fase->nombre == 'Inicio')
        <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
            <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>
            {{isset($btnText) ? $btnText : 'error'}}
        </button>
        @endif
    @else
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
        <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>
        {{isset($btnText) ? $btnText : 'error'}}
    </button>   
    @endif
    <a href="{{route('articulacion')}}" class="waves-effect red lighten-2 btn center-aling">
        <i class="material-icons right">backspace</i>Cancelar
    </a>
</center>