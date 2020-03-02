<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                        <span class="title"><b>Paso 3</b></span>
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        <span class="title"><b>Paso 2</b></span>
                    @endif
                    <p>
                        señor(a) ususario, para ingresar los talentos al uso de infraestructura debe seleccionar el talento y presionar el boton agregar talento.
                    </p>
                </li>     
            </ul>
        </blockquote>
    </div>

    <div class="col s12 m9 l9">
        <fieldset>
            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                <legend>Paso 3</legend>
            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                <legend>Paso 2</legend>
            @endif
            <p class="center card-title orange-text text-darken-3">
               <b> Talentos</b> 
            </p>
            <div class="divider"></div>
            <div class="row">
                <div class="col s12 m10 l10 offset-l1 m1">
                    
                <div class="row">
                        <div class="input-field col s10 m8 l8">
                            <select class="js-states browser-default select2" {{isset($usoinfraestructura->tipo_usoinfraestructura) && ($usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt() || $usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsArticulacion()) ? 'disabled' : ''}}   id="txttalento" name="txttalento" style="width: 100%" tabindex="-1">

                                @if(isset($usoinfraestructura->actividad->articulacion_proyecto->talentos))
                                    <option value="">
                                        Seleccione Talento
                                    </option>
                                    @foreach($usoinfraestructura->actividad->articulacion_proyecto->talentos as $talento)
                                    @if(isset($talento->user))
                                        <option value="{{$talento->id}}">
                                            {{$talento->user->documento}} - {{$talento->user->nombres}} {{$talento->user->apellidos}}
                                        </option>
                                    @endif
                                    @endforeach
                                @else
                                    @if(isset($usoinfraestructura->tipo_usoinfraestructura) && ($usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt() || $usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsArticulacion()))
                                        <option value="">
                                            No se encontraron resultados
                                        </option>
                                    @else
                                        <option value="">
                                            Seleccione primero el tipo de uso de infraestructura
                                        </option>
                                    @endif
                                    
                                @endif
                                
                            </select>
                            <label class="active" for="txttalento">
                                Talento
                            </label>
                        </div>
                        <div class="input-field col s2 m4 l4">
                            @if(isset($usoinfraestructura->tipo_usoinfraestructura) && $usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt())
                                <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 tooltipped btnAgregarTalento" data-delay="50" data-position="button" data-tooltip="Agregar Talento" disabled>
                                    <i class="material-icons">
                                        add
                                    </i>
                                </a>
                            @else
                                <a class="waves-effect waves-light btn blue m-b-xs  btnAgregarTalento" onclick="addTalentoAUso()">
                                    Agregar Talento
                                </a>
                            @endif
                            
                        </div>
                    </div>
                    <table class="striped centered responsive-table" id="tbldetallelineas">
                        <thead>
                            <tr>
                                <th>
                                    Talentos
                                </th>
                                <th>
                                    Eliminar
                                </th>
                            </tr>
                        </thead>
                        <tbody id="detalleTalento">
                            @if(isset($usoinfraestructura->usotalentos))
                                @forelse ($usoinfraestructura->usotalentos as $key => $talento)
                                    @if(isset($talento->user))
                                        <tr id="filaTalento{{$talento->id}}">
                                            <td>
                                                <input type="hidden" name="talento[]" value="{{$talento->id}}"/>
                                                
                                                {{$talento->user->documento}} - {{$talento->user->nombres}} {{$talento->user->nombres}}
                                                
                                            </td>
                                            <td>
                                                <a class="waves-effect red lighten-3 btn" onclick="eliminarTalento({{$talento->id}});">
                                                    <i class="material-icons">delete_sweep</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td>
                                            No se encontraron resultados
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    </div>
</div>