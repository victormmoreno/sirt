<div class="row">
    <div class="col s12 l3 show-on-large hide-on-med-and-down">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto() || session()->get('login_role') == App\User::IsApoyoTecnico()))
                        <span class="title"><b>Paso 4</b></span>
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        <span class="title"><b>Paso 3</b></span>
                    @endif
                    <p>señor(a) usuario, para ingresar los equipos a la asesoría y uso debe seleccionar el equipo e ingresar el tiempo de uso (horas) y presionar el boton agregar equipo.</p>
                </li>
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m12 l9">
        <fieldset>
            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto() || session()->get('login_role') == App\User::IsApoyoTecnico()))
                <legend>Paso 4</legend>
            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                <legend>Paso 3</legend>
            @endif
            <p class="center card-title primary-text"><b> Equipos</b></p>
            <div class="divider"></div>
            <div class="row">
                <div class="input-field col s12 m4 l4">
                    @if(isset($asesorie->asesorable->nodo->equipos))
                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" onchange="getEquipoPorLinea()">
                            <option value="">Seleccione Linea Tecnológica</option>
                            @foreach($asesorie->asesorable->nodo->lineas as $lineatecnologica)
                                <option value="{{$lineatecnologica->id}}">
                                    {{$lineatecnologica->abreviatura}} - {{$lineatecnologica->nombre}}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" onchange="getEquipoPorLinea()">
                            <option value="">Seleccione Linea Tecnológica</option>
                        </select>
                    @endif
                    <label class="active" for="txtlineatecnologica">
                        Linea Tecnológica
                    </label>
                </div>
                <div class="input-field col s12 m5 l4">
                    <select class="js-states browser-default select2" id="txtequipo" name="txtequipo" style="width: 100%" tabindex="-1">
                        @if(isset($asesorie->asesorable->nodo->equipos) && isset($asesorie->asesorable->asesor->lineatecnologica_id))
                            <option value="">
                                Seleccione el equipo
                            </option>
                            @foreach($asesorie->asesorable->nodo->equipos->where('lineatecnologica_id', $asesorie->asesorable->asesor->lineatecnologica_id) as $equipo)
                                <option value="{{$equipo->id}}">
                                    {{str_limit($equipo->nombre,50,"...")}}
                                </option>
                            @endforeach
                        @else
                            <option value="">
                                Seleccione primero el tipo de uso de infraestructura
                            </option>
                        @endif
                    </select>
                    <label class="active" for="txtequipo">
                        Equipo
                    </label>
                </div>
                <div class="input-field col s12 m3 l2 ">
                    <input class="validate" id="txttiempouso" name="txttiempouso" type="number"  value="1" min="0" step="0.1"/>
                    <label for="txttiempouso">
                        Tiempo Uso (Horas)
                    </label>
                    <label class="error" for="txttiempouso" id="txttiempouso-error"></label>
                </div>
                <div class="input-field col s12 m12 l2 offset-s3 offset-m4">
                    <a class="waves-effect waves-grey btn bg-secondary white-text m-b-xs btnAgregarEquipo"  onclick="agregarEquipoAusoInfraestructura()">Agregar Equipo</a>
                </div>
                <table class="striped centered responsive-table" id="tbldetallelineas">
                    <thead>
                    <tr>
                        <th>Equipo</th>
                        <th>Tiempo Uso (Horas)</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody id="detallesUsoInfraestructura">
                    @if(isset($equipos))
                        @forelse ($equipos as $key => $equipo)
                            <tr id="filaEquipo{{$equipo->id}}">
                                <td>
                                    <input type="hidden" name="equipo[]" value="{{$equipo->id}}"/>{{$equipo->nombre}}
                                </td>
                                <td>
                                    <input type="hidden" name="tiempouso[]" value="{{$equipo->pivot->tiempo}}"/>
                                    {{$equipo->pivot->tiempo}}
                                </td>
                                <td>
                                    <a class="waves-grey bg-danger white-text btn" onclick="eliminarEquipo({{$equipo->id}});">
                                        <i class="material-icons">delete_sweep</i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <td>No se encontraron resultados</td>
                            <td></td>
                            <td></td>
                        @endforelse
                    @endif
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>
</div>
